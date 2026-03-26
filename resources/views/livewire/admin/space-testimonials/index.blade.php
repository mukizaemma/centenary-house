@section('title', 'Space Testimonials')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Space to Let testimonials</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Testimonial
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
                    <th>Quote</th>
                    <th style="width: 180px;">Name</th>
                    <th style="width: 180px;">Role</th>
                    <th class="text-center" style="width: 80px;">Order</th>
                    <th class="text-center" style="width: 90px;">Status</th>
                    <th class="text-end" style="width: 120px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($testimonials as $t)
                    <tr>
                        <td>{{ \Illuminate\Support\Str::limit($t->quote, 80) }}</td>
                        <td>{{ $t->name ?? '—' }}</td>
                        <td>{{ $t->role ?? '—' }}</td>
                        <td class="text-center">{{ $t->sort_order }}</td>
                        <td class="text-center">
                            @if($t->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $t->id }})">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $t->id }})" onclick="return confirm('Delete this testimonial?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No testimonials yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">{{ $testimonials->links() }}</div>
    </div>

    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Testimonial' : 'New Testimonial' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="testimonial-form">
                            <div class="mb-3">
                                <label class="form-label">Quote</label>
                                <textarea class="form-control" rows="4" wire:model.defer="quote" placeholder="We moved our operations here and productivity improved…"></textarea>
                                @error('quote') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Name (optional)</label>
                                    <input type="text" class="form-control" wire:model.defer="name">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Role (optional)</label>
                                    <input type="text" class="form-control" wire:model.defer="role">
                                    @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Order</label>
                                    <input type="number" class="form-control" wire:model.defer="sort_order" min="0">
                                    @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" wire:model.defer="is_active">
                                <label class="form-check-label">Active</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeFormModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="testimonial-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

