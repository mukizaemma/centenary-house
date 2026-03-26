<?php

namespace App\Livewire\Frontend;

use App\Models\Room;
use App\Models\SpaceToLetPage;
use App\Models\SpaceType;
use App\Models\SpaceTestimonial;
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
        $page = SpaceToLetPage::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->first();
        $spaceTypes = SpaceType::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
        $testimonials = SpaceTestimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();
        $rooms = Room::where('is_available', true)
            ->with('images')
            ->orderBy('sort_order')
            ->get();
        $header = PageHeader::where('page_key', 'space-to-let')->first();

        return view('livewire.frontend.spaces', [
            'settings' => $settings,
            'page' => $page,
            'spaceTypes' => $spaceTypes,
            'testimonials' => $testimonials,
            'rooms' => $rooms,
            'header' => $header,
        ]);
    }
}

