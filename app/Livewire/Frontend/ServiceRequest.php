<?php

namespace App\Livewire\Frontend;

use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\WebsiteSetting;
use App\Support\SafeMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ServiceRequest extends Component
{
    public Service $service;

    public string $name = '';

    public string $company = '';

    public string $email = '';

    public string $phone = '';

    public string $budget_range = '';

    public string $move_in_timeline = '';

    public string $message = '';

    public bool $visiting_space = false;

    public string $visit_time_preference = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'budget_range' => ['nullable', 'string', 'max:120'],
            'move_in_timeline' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:4000'],
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

        [$firstName, $lastName] = $this->splitEnquiryName($this->name);

        $compiledBody = trim(implode("\n", array_filter([
            'Service: ' . $this->service->title,
            $this->company ? 'Company: ' . $this->company : null,
            $this->phone ? 'Phone: ' . $this->phone : null,
            $this->budget_range ? 'Budget range: ' . $this->budget_range : null,
            $this->move_in_timeline ? 'Timeline: ' . $this->move_in_timeline : null,
            'Visiting the space: ' . ($this->visiting_space ? 'Yes' : 'No'),
            $this->visiting_space && $this->visit_time_preference ? 'Preferred visit time: ' . $this->visit_time_preference : null,
            $this->message ? ("\nMessage:\n" . $this->message) : null,
        ])));

        $subject = 'Service request: ' . $this->service->title;

        ContactMessage::create([
            'service_id' => $this->service->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'company' => $this->company ?: null,
            'phone' => $this->phone ?: null,
            'email' => $this->email,
            'subject' => $subject,
            'budget_range' => $this->budget_range ?: null,
            'move_in_timeline' => $this->move_in_timeline ?: null,
            'message' => $compiledBody !== '' ? $compiledBody : '—',
            'visiting_space' => $this->visiting_space,
            'visit_time_preference' => $this->visiting_space ? ($this->visit_time_preference ?: null) : null,
        ]);

        $settings = WebsiteSetting::first();
        $adminEmail = $settings?->email;

        $mailOk = true;
        if ($adminEmail) {
            $mailOk = SafeMail::send(fn () => Mail::to($adminEmail)->send(new ContactFormSubmitted(
                first_name: $firstName,
                last_name: $lastName,
                email: $this->email,
                phone: $this->phone ?: null,
                formSubject: $subject,
                messageBody: $compiledBody !== '' ? $compiledBody : 'New service enquiry received.',
                visiting_space: $this->visiting_space,
                visit_time_preference: $this->visiting_space ? ($this->visit_time_preference ?: null) : null,
            ))) && $mailOk;
        }

        $mailOk = SafeMail::send(fn () => Mail::to($this->email)->send(new ContactFormConfirmation(
            first_name: $firstName,
            email: $this->email,
            messageBody: $this->message ?: 'Thank you for your interest in Centenary House services.',
        ))) && $mailOk;

        $flash = $mailOk
            ? 'Thank you! Your enquiry has been sent. We will get back to you soon.'
            : SafeMail::receivedButNotificationFailed();
        session()->flash('service_request_success', $flash);
        $this->dispatch('notify', type: $mailOk ? 'success' : 'warning', title: $mailOk ? 'Enquiry sent' : 'Enquiry received', message: $flash);

        $this->reset('name', 'company', 'email', 'phone', 'budget_range', 'move_in_timeline', 'message', 'visiting_space', 'visit_time_preference');
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function splitEnquiryName(string $name): array
    {
        $name = trim($name);
        if ($name === '') {
            return ['', '—'];
        }
        $parts = preg_split('/\s+/', $name, 2);

        return [$parts[0], $parts[1] ?? '—'];
    }

    public function render()
    {
        return view('livewire.frontend.service-request');
    }
}
