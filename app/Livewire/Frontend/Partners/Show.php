<?php

namespace App\Livewire\Frontend\Partners;

use App\Models\Partner;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontend')]
class Show extends Component
{
    public Partner $partner;

    public function mount(Partner $partner): void
    {
        abort_unless($partner->is_active, 404);
        $this->partner = $partner;
    }

    public function render()
    {
        return view('livewire.frontend.partners.show', [
            'partner' => $this->partner,
        ]);
    }
}

