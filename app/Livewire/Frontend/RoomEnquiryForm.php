<?php

namespace App\Livewire\Frontend;

use App\Mail\ContactFormConfirmation;
use App\Mail\ContactFormSubmitted;
use App\Models\Room;
use App\Models\RoomEnquiry;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class RoomEnquiryForm extends Component
{
    public Room $room;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $message = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'min:10'],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $settings = WebsiteSetting::first();
        $adminEmail = $settings?->email;
        $subject = 'Room enquiry: ' . $this->room->title;

        RoomEnquiry::create([
            'room_id' => $this->room->id,
            'visitor_name' => $this->name,
            'visitor_email' => $this->email,
            'visitor_phone' => $this->phone ?: null,
            'message' => $this->message,
            'status' => 'pending',
        ]);

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactFormSubmitted(
                first_name: $this->name,
                last_name: '',
                email: $this->email,
                phone: $this->phone ?: null,
                subject: $subject,
                message: $this->message,
            ));
        }

        Mail::to($this->email)->send(new ContactFormConfirmation(
            first_name: $this->name,
            email: $this->email,
            message: $this->message,
        ));

        $message = 'Thank you! Your enquiry for this space has been sent. We will get back to you soon.';
        session()->flash('room_enquiry_success', $message);
        $this->dispatch('notify', type: 'success', title: 'Enquiry sent', message: $message);

        $this->reset('name', 'email', 'phone', 'message');
    }

    public function render()
    {
        return view('livewire.frontend.room-enquiry-form');
    }
}

