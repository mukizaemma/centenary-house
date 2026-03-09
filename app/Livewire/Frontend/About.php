<?php

namespace App\Livewire\Frontend;

use App\Models\WebsiteSetting;
use App\Models\TeamMember;
use App\Models\PageHeader;
use Livewire\Attributes\Layout;
use Livewire\Component;

class About extends Component
{
    #[Layout('layouts.frontend')]
    public function render()
    {
        $settings = WebsiteSetting::first();
        $teamMembers = TeamMember::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $header = PageHeader::where('page_key', 'about')->first();

        return view('livewire.frontend.about', [
            'settings' => $settings,
            'teamMembers' => $teamMembers,
            'header' => $header,
        ]);
    }
}
