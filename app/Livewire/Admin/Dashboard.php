<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $totalUsers = User::count();
        $adminUsers = User::whereIn('role', ['super_admin', 'website_admin'])->count();

        return view('livewire.admin.dashboard', [
            'totalUsers' => $totalUsers,
            'adminUsers' => $adminUsers,
        ]);
    }
}
