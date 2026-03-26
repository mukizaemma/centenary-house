<?php

namespace App\Livewire\Frontend;

use App\Models\Partner;
use Livewire\Component;

class PartnersStrip extends Component
{
    public function render()
    {
        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->take(12)
            ->get();

        return view('livewire.frontend.partners-strip', [
            'partners' => $partners,
        ]);
    }
}

