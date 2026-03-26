@section('title', 'Space Types')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Space types</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Space Type
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
                    <th>Title</th>
                    <th>Starting price</th>
                    <th class="text-center" style="width: 80px;">Order</th>
                    <th class="text-center" style="width: 90px;">Status</th>
                    <th class="text-end" style="width: 120px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($spaceTypes as $t)
                    <tr>
                        <td>{{ $t->title }}</td>
                        <td>{{ $t->starting_price ?? '—' }}</td>
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
                            <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $t->id }})" onclick="return confirm('Delete this space type?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No space types yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-2">{{ $spaceTypes->links() }}</div>
    </div>

    @if($showFormModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Space Type' : 'New Space Type' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="space-type-form">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" wire:model.defer="title" placeholder="Private Offices">
                                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Starting price (optional)</label>
                                    <input type="text" class="form-control" wire:model.defer="starting_price" placeholder="Starting from 350,000 RWF / month">
                                    @error('starting_price') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sort order</label>
                                    <input type="number" class="form-control" wire:model.defer="sort_order" min="0">
                                    @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description (optional)</label>
                                <textarea class="form-control summernote" wire:model.defer="description" rows="4"></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" wire:model.defer="is_active">
                                <label class="form-check-label">Active</label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeFormModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="space-type-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

