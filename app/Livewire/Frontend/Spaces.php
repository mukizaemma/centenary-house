<?php

namespace App\Livewire\Frontend;

use App\Models\Room;
use App\Models\WebsiteSetting;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Spaces extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $rooms = Room::where('is_available', true)
            ->with('images')
            ->orderBy('sort_order')
            ->get();
        $header = PageHeader::where('page_key', 'space-to-let')->first();

        return view('livewire.frontend.spaces', [
            'settings' => $settings,
            'rooms' => $rooms,
            'header' => $header,
        ]);
    }
}

