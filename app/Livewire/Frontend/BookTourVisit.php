<?php

namespace App\Livewire\Frontend;

use App\Models\PageHeader;
use App\Models\SpaceToLetPage;
use App\Models\SpaceType;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class BookTourVisit extends Component
{
    #[Layout('layouts.frontend')]

    public ?int $preselectedSpaceTypeId = null;

    public function mount(): void
    {
        $raw = request()->query('type');
        if ($raw === null || $raw === '') {
            return;
        }

        $id = (int) $raw;
        if ($id < 1) {
            return;
        }

        if (SpaceType::query()->where('id', $id)->where('is_active', true)->exists()) {
            $this->preselectedSpaceTypeId = $id;
        }
    }

    public function render()
    {
        $settings = WebsiteSetting::first();
        $page = SpaceToLetPage::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->first();

        $effectiveMapUrl = $settings?->map_embed_url ?? $page?->google_map_embed_url;
        $header = PageHeader::where('page_key', 'book-tour')->first();

        return view('livewire.frontend.book-tour-visit', [
            'settings' => $settings,
            'page' => $page,
            'effectiveMapUrl' => $effectiveMapUrl,
            'header' => $header,
        ]);
    }
}
