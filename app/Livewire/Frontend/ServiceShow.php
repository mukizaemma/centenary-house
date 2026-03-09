<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ServiceShow extends Component
{
    #[Layout('layouts.frontend')]
    public Service $service;

    public function mount(Service $service): void
    {
        $this->service = $service;
    }

    public function render()
    {
        $settings = WebsiteSetting::first();
        $otherServices = Service::where('id', '!=', $this->service->id)
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.frontend.service-show', [
            'settings' => $settings,
            'service' => $this->service,
            'otherServices' => $otherServices,
        ]);
    }
}

