<?php

namespace App\Livewire\Admin\RoomEnquiries;

use App\Mail\RoomEnquiryResponse;
use App\Models\RoomEnquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';
    public ?int $respondingId = null;
    public ?string $admin_response = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function openRespond(int $id): void
    {
        $e = RoomEnquiry::findOrFail($id);
        $this->respondingId = $e->id;
        $this->admin_response = $e->admin_response ?? '';
    }

    public function closeRespond(): void
    {
        $this->respondingId = null;
        $this->admin_response = null;
    }

    public function saveResponse(): void
    {
        $this->validate([
            'admin_response' => ['required', 'string', 'min:10'],
        ]);

        $enquiry = RoomEnquiry::findOrFail($this->respondingId);
        $enquiry->admin_response = $this->admin_response;
        $enquiry->responded_at = now();
        $enquiry->responded_by = Auth::id();
        $enquiry->status = 'responded';
        $enquiry->save();

        if ($enquiry->visitor_email) {
            Mail::to($enquiry->visitor_email)->send(
                new RoomEnquiryResponse($enquiry->fresh('room'))
            );
        }

        $message = 'Response saved and the visitor has been notified by email.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
        $this->closeRespond();
    }

    public function getEnquiriesProperty()
    {
        return RoomEnquiry::query()
            ->with('room')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('visitor_name', 'like', '%' . $this->search . '%')
                        ->orWhere('visitor_email', 'like', '%' . $this->search . '%')
                        ->orWhere('message', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter === 'pending', fn ($q) => $q->where('status', 'pending'))
            ->when($this->statusFilter === 'responded', fn ($q) => $q->where('status', 'responded'))
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.room-enquiries.index', [
            'enquiries' => $this->enquiries,
        ]);
    }
}
