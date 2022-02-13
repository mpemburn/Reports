<div class="max-w-7xl mx-auto my-4">
    <div wire:click="syncWithToggl" class="text-sm sm:text-right" style="cursor: pointer;">
            <span class="fas fa-sync @if($syncing) fa-spin @endif"></span>
        SYNC
    </div>
    <table style="width: 100%;">
        <thead style="background-color: #e2e8f0;">
        <th class="py-2">Task ID</th>
        <th>Description</th>
        <th>Dates</th>
        <th>Total Logged</th>
        <th></th>
        </thead>
        <tbody>
        @foreach($data as $entry)
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                <td class="py-2">{{ $entry['ticket_id'] }}</td>
                <td>{{ $entry['description'] }}</td>
                <td class="pr-1" style="text-align: right;">{{ $entry['date_span'] }}</td>
                <td style="text-align: right;">{{ $entry['duration'] }}</td>
                <td>&nbsp;
{{--                    <span--}}
{{--                        @click="copyDuration($entry['duration'])"--}}
{{--                        class="far fa-clipboard"--}}
{{--                        style="cursor: pointer;"--}}
{{--                    ></span>--}}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

</div>
