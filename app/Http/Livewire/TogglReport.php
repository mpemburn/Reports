<?php

namespace App\Http\Livewire;

use App\Services\TogglService;
use Livewire\Component;

class TogglReport extends Component
{
    public bool $syncing = false;
    public array $data = [];

    public function syncWithToggl(): void
    {
        $this->syncing = true;
        if ((new TogglService())->importFromApi()) {
            $this->syncing = false;
        }
    }

    public function render()
    {
        $this->data = (new TogglService())->getEntries();

        return view('components.toggl-report', ['data' => $this->data, 'syncing' => $this->syncing]);
    }
}
