<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Ixudra\Toggl\Facades\Toggl as TogglApi;
use App\Models\Toggl;
use DateInterval;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use stdClass;

class TogglService
{
    protected Collection $syncIds;

    public function __construct()
    {
        $this->syncIds = collect();
    }

    public function importFromApi(string $start = null, string $end = null): void
    {
        if ($start && $end) {
            $data[ 'since' ] = Carbon::parse($start)
                ->startOfWeek()
                ->toDateString();
            $data[ 'until' ] = Carbon::parse($end)
                ->endOfWeek()
                ->toDateString();
            $response = TogglApi::detailed($data);
        } else {
            $response = TogglApi::detailedThisYear();
        }

        collect($response)->each(function ($item) {
            if (is_array($item)) {
                collect($item)->each(function ($entry) {
                    if (property_exists($entry, 'id')) {
                        // Save this ID in the collection to facilitate soft deletes
                        $this->syncIds->push($entry->id);
                        // Make sure this isn't a duplicate
                        if (Toggl::where('public_id', $entry->id)->exists()) {
                            return;
                        }

                        $this->saveEntry($entry);
                    }
                });
            }
        });
        $this->deleteRemovedItems();
    }

    public function getEntries()
    {
        return Toggl::select(['ticket_id', 'description'])
            ->groupBy(['ticket_id', 'description'])
            ->orderBy('start_time', 'DESC')
            ->get()
            ->map(function (Toggl $toggl) {
                $total = $this->calculateDuration($toggl->ticket_id);
                $duration = $this->durationToString($total);

                return [
                    'id' => $toggl->id,
                    'ticket_id' => $toggl->ticket_id,
                    'description' => $toggl->description,
                    'duration' => $duration
                ];
            })->toArray();
    }

    protected function saveEntry(stdClass $entry): void
    {
        // Parse the ticket ID out of the description
        preg_match('/(TS-[\d]+|TRAK-[\d]+)(.*)/', $entry->description, $matches);

        if (isset($matches[1])) {
            $toggl = new Toggl([
                'public_id' => $entry->id,
                'uid' => $entry->uid,
                'ticket_id' => $matches[1],
                'description' => trim($matches[2]),
                'duration' => $entry->dur,
                'start_time' => Carbon::parse($entry->start),
                'end_time' => Carbon::parse($entry->end),
            ]);

            $toggl->save();
        }
    }

    protected function calculateDuration($ticketId): DateInterval
    {
        $midnight = Carbon::now('America/New_York')->startOfDay();
        $aggregate = Carbon::now('America/New_York')->startOfDay();
        $total = 0;
        Toggl::where('ticket_id', $ticketId)->orderBy('ticket_id')
            ->each(function (Toggl $toggl) use (&$total) {
                $total += ($toggl->duration / 1000);
            });

        return $midnight->diff($aggregate->addSeconds($total));
    }

    protected function durationToString(DateInterval $total): string
    {
        $timeParts = collect();
        $timeParts->push($total->d > 0 ? "{$total->d} " . trans_choice('time.day', $total->d) : null);
        $timeParts->push($total->h > 0 ? "{$total->h} " . trans_choice('time.hour', $total->h) : null);
        $timeParts->push($total->i > 0 ? "{$total->i} " . trans_choice('time.minute', $total->i) : null);

        return trim($timeParts->implode(' '));
    }

    protected function deleteRemovedItems(): void
    {
        $removed = Toggl::whereNotIn('public_id', $this->syncIds->toArray());

        $removed->get()->each(function (Toggl $toggl) {
            $toggl->delete();
        });
    }

}
