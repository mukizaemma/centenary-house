<?php

namespace App\Livewire\Frontend;

use App\Models\HomeSlider;
use App\Models\Room;
use App\Models\Service;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $sliders = HomeSlider::where('is_active', true)->orderBy('sort_order')->get();
        $featuredRooms = Room::where('is_available', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('livewire.frontend.home', [
            'settings' => $settings,
            'sliders' => $sliders,
            'featuredRooms' => $featuredRooms,
            'services' => $services,
        ]);
    }
}
