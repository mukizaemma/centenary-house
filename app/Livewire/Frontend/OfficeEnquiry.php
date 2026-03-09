<?php

namespace App\Livewire\Frontend;

use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class OfficeEnquiry extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $phone = '';
    public string $email = '';
    public string $message = '';

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $settings = WebsiteSetting::first();
        $adminEmail = $settings?->email;
        $subject = 'Office space enquiry (homepage)';

        ContactMessage::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone ?: null,
            'email' => $this->email,
            'subject' => $subject,
            'message' => $this->message,
        ]);

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactFormSubmitted(
                first_name: $this->first_name,
                last_name: $this->last_name,
                email: $this->email,
                phone: $this->phone ?: null,
                subject: $subject,
                message: $this->message,
            ));
        }

        Mail::to($this->email)->send(new ContactFormConfirmation(
            first_name: $this->first_name,
            email: $this->email,
            message: $this->message,
        ));

        $message = 'Thank you! Your office enquiry has been sent. We will get back to you soon.';
        session()->flash('office_enquiry_success', $message);
        $this->dispatch('notify', type: 'success', title: 'Enquiry sent', message: $message);

        $this->reset('first_name', 'last_name', 'phone', 'email', 'message');
    }

    public function render()
    {
        return view('livewire.frontend.office-enquiry');
    }
}

