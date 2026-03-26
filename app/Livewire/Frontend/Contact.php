<?php

namespace App\Livewire\Frontend;

use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\PageHeader;
use App\Models\WebsiteSetting;
use App\Support\SafeMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Contact extends Component
{
    #[Layout('layouts.frontend')]

    public string $first_name = '';

    public string $last_name = '';

    public string $phone = '';

    public string $email = '';

    public string $subject = '';

    public string $message = '';

    public bool $visiting_space = false;

    public string $visit_time_preference = '';

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
            'visiting_space' => ['boolean'],
            'visit_time_preference' => ['nullable', 'string', 'max:255', 'required_if:visiting_space,true'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        if (! $this->visiting_space) {
            $this->visit_time_preference = '';
        }

        $settings = WebsiteSetting::first();
        $adminEmail = $settings?->email;

        ContactMessage::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone ?: null,
            'email' => $this->email,
            'subject' => $this->subject ?: null,
            'message' => $this->message,
            'visiting_space' => $this->visiting_space,
            'visit_time_preference' => $this->visiting_space ? ($this->visit_time_preference ?: null) : null,
        ]);

        $mailOk = true;
        if ($adminEmail) {
            $mailOk = SafeMail::send(fn () => Mail::to($adminEmail)->send(new ContactFormSubmitted(
                first_name: $this->first_name,
                last_name: $this->last_name,
                email: $this->email,
                phone: $this->phone ?: null,
                formSubject: $this->subject ?: null,
                messageBody: $this->message,
                visiting_space: $this->visiting_space,
                visit_time_preference: $this->visiting_space ? ($this->visit_time_preference ?: null) : null,
            ))) && $mailOk;
        }

        $mailOk = SafeMail::send(fn () => Mail::to($this->email)->send(new ContactFormConfirmation(
            first_name: $this->first_name,
            email: $this->email,
            messageBody: $this->message,
        ))) && $mailOk;

        $flash = $mailOk
            ? 'Thank you! Your message has been sent. We will get back to you soon.'
            : SafeMail::receivedButNotificationFailed();
        session()->flash('contact_success', $flash);
        $this->dispatch('notify', type: $mailOk ? 'success' : 'warning', title: $mailOk ? 'Message sent' : 'Message received', message: $flash);
        $this->reset('first_name', 'last_name', 'phone', 'email', 'subject', 'message', 'visiting_space', 'visit_time_preference');
    }

    public function render()
    {
        $header = PageHeader::where('page_key', 'contact')->first();
        $settings = WebsiteSetting::first();

        return view('livewire.frontend.contact', [
            'header' => $header,
            'settings' => $settings,
        ]);
    }
}
