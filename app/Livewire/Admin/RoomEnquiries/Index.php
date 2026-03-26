<?php

namespace App\Livewire\Admin\RoomEnquiries;

use App\Mail\FormEnquiryReply;
use App\Models\ContactMessage;
use App\Models\RoomEnquiry;
use App\Models\SpaceToLetEnquiry;
use App\Support\SafeMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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

    public ?string $respondingSource = null;

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

    public function openRespond(string $source, int $id): void
    {
        $this->respondingSource = $source;
        $this->respondingId = $id;
        $this->admin_response = match ($source) {
            'room' => RoomEnquiry::findOrFail($id)->admin_response ?? '',
            'contact' => ContactMessage::findOrFail($id)->admin_response ?? '',
            'space' => SpaceToLetEnquiry::findOrFail($id)->admin_response ?? '',
            default => '',
        };
    }

    public function closeRespond(): void
    {
        $this->respondingSource = null;
        $this->respondingId = null;
        $this->admin_response = null;
    }

    public function saveResponse(): void
    {
        $this->validate([
            'admin_response' => ['required', 'string', 'min:10'],
        ]);

        $enquiry = match ($this->respondingSource) {
            'room' => RoomEnquiry::findOrFail($this->respondingId),
            'contact' => ContactMessage::findOrFail($this->respondingId),
            'space' => SpaceToLetEnquiry::findOrFail($this->respondingId),
            default => null,
        };

        if ($enquiry === null) {
            return;
        }

        $enquiry->admin_response = $this->admin_response;
        $enquiry->responded_at = now();
        $enquiry->responded_by = Auth::id();
        $enquiry->status = 'responded';
        $enquiry->save();

        $visitorEmail = match ($this->respondingSource) {
            'room' => $enquiry->visitor_email,
            'contact', 'space' => $enquiry->email,
            default => null,
        };

        $visitorName = match ($this->respondingSource) {
            'room' => $enquiry->visitor_name,
            'contact' => trim($enquiry->first_name.' '.$enquiry->last_name),
            'space' => $enquiry->name,
            default => '',
        };

        $fresh = match ($this->respondingSource) {
            'room' => RoomEnquiry::with('room')->findOrFail($enquiry->id),
            'contact' => ContactMessage::with('service')->findOrFail($enquiry->id),
            'space' => SpaceToLetEnquiry::with('spaceType')->findOrFail($enquiry->id),
            default => $enquiry,
        };

        $contextLabel = $this->replyContextLabel((string) $this->respondingSource, $fresh);
        $originalMessage = (string) ($enquiry->message ?? '');

        $mailOk = true;
        if ($visitorEmail) {
            $mailOk = SafeMail::send(fn () => Mail::to($visitorEmail)->send(
                new FormEnquiryReply(
                    visitorName: $visitorName,
                    contextLabel: $contextLabel,
                    originalMessage: $originalMessage,
                    adminResponse: $this->admin_response,
                )
            ));
        }

        $message = $mailOk
            ? 'Response saved and the visitor has been notified by email.'
            : SafeMail::adminSavedButVisitorMailFailed();
        session()->flash('success', $message);
        $this->dispatch('notify', type: $mailOk ? 'success' : 'warning', title: $mailOk ? 'Success' : 'Partial success', message: $message);
        $this->closeRespond();
    }

    private function replyContextLabel(string $source, Model $enquiry): string
    {
        return match ($source) {
            'room' => 'Room: '.($enquiry instanceof RoomEnquiry ? ($enquiry->room?->title ?? 'Listing') : 'Listing'),
            'contact' => $enquiry instanceof ContactMessage
                ? ($enquiry->service
                    ? 'Service: '.$enquiry->service->title
                    : ($enquiry->subject ? 'Subject: '.$enquiry->subject : 'Contact form'))
                : 'Contact form',
            'space' => 'Space to let: '.($enquiry instanceof SpaceToLetEnquiry
                ? ($enquiry->spaceType?->title ?? $enquiry->space_needed ?? 'Enquiry')
                : 'Enquiry'),
            default => 'Enquiry',
        };
    }

    private function mergedRows(): Collection
    {
        $search = $this->search;
        $status = $this->statusFilter;

        $roomQuery = RoomEnquiry::query()->with('room');
        if ($search !== '') {
            $roomQuery->where(function ($q) use ($search) {
                $q->where('visitor_name', 'like', '%'.$search.'%')
                    ->orWhere('visitor_email', 'like', '%'.$search.'%')
                    ->orWhere('message', 'like', '%'.$search.'%');
            });
        }
        if ($status === 'pending') {
            $roomQuery->where('status', 'pending');
        } elseif ($status === 'responded') {
            $roomQuery->where('status', 'responded');
        }

        $contactQuery = ContactMessage::query()->with('service');
        if ($search !== '') {
            $contactQuery->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('subject', 'like', '%'.$search.'%')
                    ->orWhere('message', 'like', '%'.$search.'%');
            });
        }
        if ($status === 'pending') {
            $contactQuery->where('status', 'pending');
        } elseif ($status === 'responded') {
            $contactQuery->where('status', 'responded');
        }

        $spaceQuery = SpaceToLetEnquiry::query()->with('spaceType');
        if ($search !== '') {
            $spaceQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('space_needed', 'like', '%'.$search.'%')
                    ->orWhere('message', 'like', '%'.$search.'%');
            });
        }
        if ($status === 'pending') {
            $spaceQuery->where('status', 'pending');
        } elseif ($status === 'responded') {
            $spaceQuery->where('status', 'responded');
        }

        $rows = collect();

        foreach ($roomQuery->get() as $e) {
            $rows->push([
                'source' => 'room',
                'id' => $e->id,
                'type_label' => 'Room',
                'context' => $e->room?->title ?? '—',
                'visitor' => $e->visitor_name,
                'email' => $e->visitor_email,
                'phone' => $e->visitor_phone,
                'message' => $e->message,
                'status' => $e->status,
                'created_at' => $e->created_at,
            ]);
        }

        foreach ($contactQuery->get() as $e) {
            $context = $e->service
                ? $e->service->title
                : ($e->subject ?: 'Contact');
            $rows->push([
                'source' => 'contact',
                'id' => $e->id,
                'type_label' => 'Contact / service',
                'context' => $context,
                'visitor' => trim($e->first_name.' '.$e->last_name),
                'email' => $e->email,
                'phone' => $e->phone,
                'message' => $e->message,
                'status' => $e->status ?? 'pending',
                'created_at' => $e->created_at,
            ]);
        }

        foreach ($spaceQuery->get() as $e) {
            $rows->push([
                'source' => 'space',
                'id' => $e->id,
                'type_label' => 'Space to let',
                'context' => $e->spaceType?->title ?? $e->space_needed ?? '—',
                'visitor' => $e->name,
                'email' => $e->email,
                'phone' => $e->phone,
                'message' => $e->message ?? '',
                'status' => $e->status ?? 'pending',
                'created_at' => $e->created_at,
            ]);
        }

        return $rows->sortByDesc(fn ($r) => $r['created_at']->timestamp)->values();
    }

    public function getEnquiriesProperty()
    {
        $rows = $this->mergedRows();
        $perPage = 15;
        $page = (int) LengthAwarePaginator::resolveCurrentPage();
        $items = $rows->slice(($page - 1) * $perPage, $perPage)->values();

        return (new LengthAwarePaginator(
            $items,
            $rows->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        ))->withQueryString();
    }

    public function getModalEnquiryProperty()
    {
        if ($this->respondingSource === null || $this->respondingId === null) {
            return null;
        }

        return match ($this->respondingSource) {
            'room' => RoomEnquiry::with('room')->find($this->respondingId),
            'contact' => ContactMessage::with('service')->find($this->respondingId),
            'space' => SpaceToLetEnquiry::with('spaceType')->find($this->respondingId),
            default => null,
        };
    }

    public function getModalTitleProperty(): string
    {
        return match ($this->respondingSource) {
            'room' => 'Room enquiry',
            'contact' => 'Contact / service enquiry',
            'space' => 'Space to let enquiry',
            default => 'Enquiry',
        };
    }

    public function render()
    {
        return view('livewire.admin.room-enquiries.index', [
            'enquiries' => $this->enquiries,
            'modalEnquiry' => $this->modalEnquiry,
            'modalTitle' => $this->modalTitle,
        ]);
    }
}
