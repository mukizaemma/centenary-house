<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin-auth')]
class ForgotPassword extends Component
{
    public string $email = '';

    protected $rules = [
        'email' => ['required', 'email'],
    ];

    public function sendResetLink(): void
    {
        $this->validate();

        $status = Password::broker()->sendResetLink([
            'email' => $this->email,
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            $message = __($status);
            session()->flash('status', $message);
            $this->dispatch('notify', type: 'success', title: 'Email sent', message: $message);
        } else {
            $errorMessage = __($status);
            $this->addError('email', $errorMessage);
            $this->dispatch('notify', type: 'error', title: 'Error', message: $errorMessage);
        }
    }

    public function render()
    {
        return view('livewire.admin.auth.forgot-password');
    }
}

