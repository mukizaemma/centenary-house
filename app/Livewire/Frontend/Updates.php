<?php

namespace App\Livewire\Frontend;

use App\Models\WebsiteSetting;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Updates extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $header = PageHeader::where('page_key', 'updates')->first();

        return view('livewire.frontend.updates', [
            'settings' => $settings,
            'header' => $header,
        ]);
    }
}

