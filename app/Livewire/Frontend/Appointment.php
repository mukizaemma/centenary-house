<?php

namespace App\Livewire\Frontend;

use App\Models\PageHeader;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Appointment extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $header = PageHeader::where('page_key', 'contact')->first();
        $settings = WebsiteSetting::first();

        return view('livewire.frontend.appointment', [
            'header' => $header,
            'settings' => $settings,
        ]);
    }
}
