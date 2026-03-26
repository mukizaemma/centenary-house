<?php

namespace App\Livewire\Frontend\Partners;

use App\Models\Partner;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Index extends Component
{
    public function render()
    {
        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('livewire.frontend.partners.index', [
            'partners' => $partners,
        ]);
    }
}

