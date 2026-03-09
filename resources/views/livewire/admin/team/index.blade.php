@section('title', 'Team')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Team</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search by name, position, email..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Member
                </button>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle w-100">
                <thead>
                    <tr>
                        <th style="width: 70px;">Photo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Contact</th>
                        <th class="text-center" style="width: 80px;">Order</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teamMembers as $m)
                        <tr>
                            <td>
                                @if($m->photo_path)
                                    <img src="{{ asset($m->photo_path) }}" alt="" class="rounded-circle border" style="height: 48px; width: 48px; object-fit: cover;">
                                @else
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary text-white" style="height: 48px; width: 48px;">{{ strtoupper(substr($m->full_name, 0, 1)) }}</span>
                                @endif
                            </td>
                            <td>{{ $m->full_name }}</td>
                            <td>{{ $m->position }}</td>
                            <td>
                                @if($m->email)<small>{{ $m->email }}</small>@endif
                                @if($m->phone)<br><small>{{ $m->phone }}</small>@endif
                                @if(!$m->email && !$m->phone)<span class="text-muted">—</span>@endif
                            </td>
                            <td class="text-center">{{ $m->sort_order ?? '—' }}</td>
                            <td class="text-center">
                                @if($m->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $m->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $m->id }})" onclick="return confirm('Delete this team member?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No team members yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $teamMembers->links() }}</div>
    </div>

    {{-- Form Modal --}}
    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Team Member' : 'New Team Member' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="team-form">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" wire:model.defer="full_name" placeholder="e.g. John Doe">
                                    @error('full_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Photo</label>
                                    <input type="file" class="form-control" wire:model="photo" accept="image/*">
                                    @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                                    @if($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 100px;">
                                    @elseif($photo_path)
                                        <img src="{{ asset($photo_path) }}" alt="Current" class="img-fluid rounded mt-2" style="max-height: 100px;">
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <input type="text" class="form-control" wire:model.defer="position" placeholder="e.g. Facility Manager">
                                @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" wire:model.defer="email" placeholder="optional">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" wire:model.defer="phone" placeholder="optional">
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Biography</label>
                                <textarea class="form-control summernote" wire:model.defer="biography" rows="3"></textarea>
                                @error('biography') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" class="form-control" wire:model.defer="sort_order" min="0" style="max-width: 120px;">
                                    @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3 d-flex align-items-end">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" wire:model.defer="is_active">
                                        <label class="form-check-label">Active</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeFormModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="team-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
