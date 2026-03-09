@section('title', 'Room Enquiries')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Room Enquiries & Comments</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search by name, email, message..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <select class="form-select form-select-sm" wire:model.live="statusFilter" style="width: auto;">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="responded">Responded</option>
                </select>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Visitor</th>
                        <th>Message</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th style="width: 140px;">Date</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $e)
                        <tr>
                            <td>{{ $e->room?->title ?? '—' }}</td>
                            <td>
                                <strong>{{ $e->visitor_name }}</strong><br>
                                <small>{{ $e->visitor_email }}</small>
                                @if($e->visitor_phone)
                                    <br><small>{{ $e->visitor_phone }}</small>
                                @endif
                            </td>
                            <td><div class="text-truncate" style="max-width: 280px;">{{ $e->message }}</div></td>
                            <td class="text-center">
                                @if($e->status === 'responded')
                                    <span class="badge bg-success">Responded</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td><small>{{ $e->created_at->format('d M Y H:i') }}</small></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary" wire:click="openRespond({{ $e->id }})">
                                    <i class="fa fa-reply"></i> {{ $e->status === 'responded' ? 'View' : 'Respond' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No enquiries yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $enquiries->links() }}</div>
    </div>

    {{-- Respond Modal --}}
    @if($respondingId)
        @php $enquiry = \App\Models\RoomEnquiry::with('room')->find($respondingId); @endphp
        @if($enquiry)
            <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Respond to enquiry – {{ $enquiry->room?->title }}</h5>
                            <button type="button" class="btn-close" wire:click="closeRespond" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">From</label>
                                <p class="mb-0">{{ $enquiry->visitor_name }} &lt;{{ $enquiry->visitor_email }}&gt;@if($enquiry->visitor_phone) · {{ $enquiry->visitor_phone }}@endif</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Message</label>
                                <div class="bg-light rounded p-3">{{ $enquiry->message }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Your response</label>
                                <textarea class="form-control" wire:model.defer="admin_response" rows="5" placeholder="Type your reply to the visitor..."></textarea>
                                @error('admin_response') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" wire:click="closeRespond">Cancel</button>
                            <button type="button" class="btn btn-primary" wire:click="saveResponse">
                                <i class="fa fa-save me-1"></i> Save response
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
