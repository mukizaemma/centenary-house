<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use App\Models\WebsiteSetting;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Services extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $header = PageHeader::where('page_key', 'services')->first();

        return view('livewire.frontend.services', [
            'settings' => $settings,
            'services' => $services,
            'header' => $header,
        ]);
    }
}

