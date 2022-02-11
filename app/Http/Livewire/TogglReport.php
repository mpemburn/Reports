<?php

namespace App\Http\Livewire;

use App\Services\TogglService;
use Livewire\Component;

class TogglReport extends Component
{
    private TogglService $service;

    public function mount(TogglService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $data = $this->service->getEntries();

        return view('components.toggl-report', ['data' => $data]);
    }
}
