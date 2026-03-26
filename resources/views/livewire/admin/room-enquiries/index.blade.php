@section('title', 'Enquiries')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
                <h4 class="mb-1">Room enquiries &amp; form submissions</h4>
                <p class="text-muted small mb-0">Room listings, contact / service requests, and space-to-let enquiries in one place.</p>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-2 mt-md-0">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search name, email, message..."
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
                        <th style="width: 130px;">Type</th>
                        <th>Context</th>
                        <th>Visitor</th>
                        <th>Message</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th style="width: 140px;">Date</th>
                        <th class="text-end" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enquiries as $row)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $row['type_label'] }}</span></td>
                            <td><div class="text-truncate" style="max-width: 200px;" title="{{ $row['context'] }}">{{ $row['context'] }}</div></td>
                            <td>
                                <strong>{{ $row['visitor'] }}</strong><br>
                                <small>{{ $row['email'] }}</small>
                                @if(!empty($row['phone']))
                                    <br><small>{{ $row['phone'] }}</small>
                                @endif
                            </td>
                            <td><div class="text-truncate" style="max-width: 280px;">{{ $row['message'] !== '' ? $row['message'] : '—' }}</div></td>
                            <td class="text-center">
                                @if(($row['status'] ?? 'pending') === 'responded')
                                    <span class="badge bg-success">Responded</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td><small>{{ $row['created_at']->format('d M Y H:i') }}</small></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary" wire:click="openRespond('{{ $row['source'] }}', {{ $row['id'] }})">
                                    <i class="fa fa-reply"></i> {{ ($row['status'] ?? 'pending') === 'responded' ? 'View' : 'Respond' }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No enquiries yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $enquiries->links() }}</div>
    </div>

    {{-- Respond Modal --}}
    @if($respondingId && $modalEnquiry)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Respond — {{ $modalTitle }}</h5>
                        <button type="button" class="btn-close" wire:click="closeRespond" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-muted">From</label>
                            @if($respondingSource === 'room')
                                <p class="mb-0">{{ $modalEnquiry->visitor_name }} &lt;{{ $modalEnquiry->visitor_email }}&gt;@if($modalEnquiry->visitor_phone) · {{ $modalEnquiry->visitor_phone }}@endif</p>
                            @elseif($respondingSource === 'contact')
                                <p class="mb-0">{{ $modalEnquiry->first_name }} {{ $modalEnquiry->last_name }} &lt;{{ $modalEnquiry->email }}&gt;@if($modalEnquiry->phone) · {{ $modalEnquiry->phone }}@endif</p>
                            @else
                                <p class="mb-0">{{ $modalEnquiry->name }} &lt;{{ $modalEnquiry->email }}&gt;@if($modalEnquiry->phone) · {{ $modalEnquiry->phone }}@endif</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Their message</label>
                            <div class="bg-light rounded p-3">{{ $modalEnquiry->message ?? '—' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Your personalized response</label>
                            <textarea class="form-control" wire:model.defer="admin_response" rows="6" placeholder="Type your reply to the visitor..."></textarea>
                            @error('admin_response') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeRespond">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="saveResponse">
                            <i class="fa fa-save me-1"></i> Save &amp; send email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
