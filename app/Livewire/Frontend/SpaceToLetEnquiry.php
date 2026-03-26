<?php

namespace App\Livewire\Frontend;

use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmitted;
use App\Models\SpaceToLetEnquiry as SpaceToLetEnquiryModel;
use App\Models\SpaceType;
use App\Models\WebsiteSetting;
use App\Support\SafeMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SpaceToLetEnquiry extends Component
{
    public function mount(?int $spaceTypeId = null): void
    {
        if ($spaceTypeId === null) {
            return;
        }

        if (SpaceType::query()->where('id', $spaceTypeId)->where('is_active', true)->exists()) {
            $this->space_type_id = $spaceTypeId;
        }
    }

    public string $name = '';

    public string $company = '';

    public string $email = '';

    public string $phone = '';

    public ?int $space_type_id = null;

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
            'space_type_id' => ['required', 'integer', 'exists:space_types,id'],
            'budget_range' => ['nullable', 'string', 'max:120'],
            'move_in_timeline' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:4000'],
            'visiting_space' => ['boolean'],
            'visit_time_preference' => ['nullable', 'string', 'max:255', 'required_if:visiting_space,true'],
        ];
    }

    public function submit(): void
    {
        $data = $this->validate();

        if (! $this->visiting_space) {
            $this->visit_time_preference = '';
        }

        $spaceType = SpaceType::find($data['space_type_id']);

        SpaceToLetEnquiryModel::create([
            'name' => $data['name'],
            'company' => $data['company'] ?: null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?: null,
            'space_type_id' => $data['space_type_id'],
            'space_needed' => $spaceType?->title,
            'budget_range' => $data['budget_range'] ?: null,
            'move_in_timeline' => $data['move_in_timeline'] ?: null,
            'message' => $data['message'] ?: null,
            'visiting_space' => $this->visiting_space,
            'visit_time_preference' => $this->visiting_space ? ($this->visit_time_preference ?: null) : null,
        ]);

        $settings = WebsiteSetting::first();
        $adminEmail = $settings?->email;

        $subject = 'Space to Let enquiry';
        $compiledMessage = trim(implode("\n", array_filter([
            'Space needed: ' . ($spaceType?->title ?? '—'),
            $this->company ? 'Company: ' . $this->company : null,
            $this->phone ? 'Phone: ' . $this->phone : null,
            $this->budget_range ? 'Budget range: ' . $this->budget_range : null,
            $this->move_in_timeline ? 'Move-in timeline: ' . $this->move_in_timeline : null,
            'Visiting the space: ' . ($this->visiting_space ? 'Yes' : 'No'),
            $this->visiting_space && $this->visit_time_preference ? 'Preferred visit time: ' . $this->visit_time_preference : null,
            $this->message ? ("\nMessage:\n" . $this->message) : null,
        ])));

        $mailOk = true;
        if ($adminEmail) {
            $mailOk = SafeMail::send(fn () => Mail::to($adminEmail)->send(new ContactFormSubmitted(
                first_name: $this->name,
                last_name: '',
                email: $this->email,
                phone: $this->phone ?: null,
                formSubject: $subject,
                messageBody: $compiledMessage !== '' ? $compiledMessage : 'New enquiry received.',
                visiting_space: $this->visiting_space,
                visit_time_preference: $this->visiting_space ? ($this->visit_time_preference ?: null) : null,
            ))) && $mailOk;
        }

        $mailOk = SafeMail::send(fn () => Mail::to($this->email)->send(new ContactFormConfirmation(
            first_name: $this->name,
            email: $this->email,
            messageBody: $this->message ?: 'Thank you for contacting us about office spaces at Centenary House.',
        ))) && $mailOk;

        $flash = $mailOk
            ? 'Thank you! Your enquiry has been sent. We will get back to you soon.'
            : SafeMail::receivedButNotificationFailed();
        session()->flash('space_to_let_enquiry_success', $flash);
        $this->dispatch('notify', type: $mailOk ? 'success' : 'warning', title: $mailOk ? 'Enquiry sent' : 'Enquiry received', message: $flash);

        $this->reset('name', 'company', 'email', 'phone', 'space_type_id', 'budget_range', 'move_in_timeline', 'message', 'visiting_space', 'visit_time_preference');
    }

    public function render()
    {
        $spaceTypes = SpaceType::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('livewire.frontend.space-to-let-enquiry', [
            'spaceTypes' => $spaceTypes,
        ]);
    }
}
