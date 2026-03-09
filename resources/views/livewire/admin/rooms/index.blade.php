@section('title', 'Rooms')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <h4 class="mb-2">Rooms</h4>
            <div class="d-flex flex-wrap gap-2">
                <input
                    type="text"
                    class="form-control form-control-sm"
                    placeholder="Search rooms..."
                    wire:model.debounce.300ms="search"
                    style="min-width: 220px;"
                >
                <button class="btn btn-sm btn-primary" wire:click="create">
                    <i class="fa fa-plus me-1"></i> New Room
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
                        <th style="width: 80px;">Cover</th>
                        <th>Title</th>
                        <th class="text-center">Floor</th>
                        <th class="text-center">m²</th>
                        <th class="text-end">Amount</th>
                        <th class="text-center" style="width: 70px;">Gallery</th>
                        <th class="text-center" style="width: 90px;">Available</th>
                        <th class="text-center" style="width: 70px;">Order</th>
                        <th class="text-end" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $r)
                        <tr>
                            <td>
                                @if($r->cover_image_path)
                                    <img src="{{ asset($r->cover_image_path) }}" alt="" class="rounded border" style="height: 50px; width: 70px; object-fit: cover;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $r->title }}</td>
                            <td class="text-center">{{ $r->floor ?? '—' }}</td>
                            <td class="text-center">{{ $r->square_meters !== null ? number_format($r->square_meters, 0) : '—' }}</td>
                            <td class="text-end">{{ $r->amount !== null ? number_format($r->amount) : '—' }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="openGalleryModal({{ $r->id }})" title="Manage gallery">
                                    <i class="fa fa-images"></i> {{ $r->images_count }}
                                </button>
                            </td>
                            <td class="text-center">
                                @if($r->is_available)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unavailable</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $r->sort_order ?? '—' }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" wire:click="edit({{ $r->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" wire:click="delete({{ $r->id }})" onclick="return confirm('Delete this room and its gallery?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No rooms yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-2">{{ $rooms->links() }}</div>
    </div>

    {{-- Room Form Modal --}}
    @if($showFormModal && !$showGalleryModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $editingId ? 'Edit Room' : 'New Room' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeFormModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save" id="room-form">
                            <div class="mb-3">
                                <label class="form-label">Room Title</label>
                                <input type="text" class="form-control" wire:model.defer="title" placeholder="e.g. Office Suite A">
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Floor</label>
                                    <select class="form-select" wire:model.defer="floor">
                                        <option value="">Select floor</option>
                                        <option value="Ground">Ground Floor</option>
                                        <option value="1st">1st Floor</option>
                                        <option value="2nd">2nd Floor</option>
                                        <option value="3rd">3rd Floor</option>
                                        <option value="4th">4th Floor</option>
                                        <option value="5th">5th Floor</option>
                                        <option value="6th">6th Floor</option>
                                    </select>
                                    @error('floor') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Square Meters</label>
                                    <input type="number" class="form-control" wire:model.defer="square_meters" min="0" step="0.01" placeholder="0">
                                    @error('square_meters') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Amount per m²</label>
                                    <input type="number" class="form-control" wire:model.defer="amount_per_sqm" min="0" step="0.01" placeholder="optional">
                                    @error('amount_per_sqm') <small class="text-danger">{{ $message }}</small> @enderror
                                    @if($square_meters && $amount_per_sqm)
                                        <small class="text-muted d-block mt-1">
                                            Estimated monthly amount: {{ number_format($square_meters * $amount_per_sqm, 2) }}
                                        </small>
                                    @endif
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Custom Monthly Amount</label>
                                    <input type="number" class="form-control" wire:model.defer="amount" min="0" step="0.01" placeholder="optional">
                                    @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                                    <small class="text-muted d-block mt-1">
                                        If both are filled, per m² rate will be used.
                                    </small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cover Image</label>
                                <input type="file" class="form-control" wire:model="cover_image" accept="image/*">
                                @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
                                @if($cover_image)
                                    <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview" class="img-fluid rounded mt-2" style="max-height: 120px;">
                                @elseif($cover_image_path)
                                    <img src="{{ asset($cover_image_path) }}" alt="Current" class="img-fluid rounded mt-2" style="max-height: 120px;">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control summernote" wire:model.defer="description" rows="4"></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" wire:model.defer="is_available">
                                <label class="form-check-label">Available for rent</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" class="form-control" wire:model.defer="sort_order" min="0">
                                @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeFormModal">Cancel</button>
                        <button type="submit" class="btn btn-primary" form="room-form">
                            <i class="fa fa-save me-1"></i> {{ $editingId ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Gallery Modal --}}
    @if($showGalleryModal && $galleryRoom)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-images me-2"></i>Gallery: {{ $galleryRoom->title }}</h5>
                        <button type="button" class="btn-close" wire:click="closeGalleryModal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">Add images</label>
                            <input type="file" class="form-control" wire:model="gallery_images" accept="image/*" multiple>
                            @error('gallery_images') <small class="text-danger">{{ $message }}</small> @enderror
                            @error('gallery_images.*') <small class="text-danger">{{ $message }}</small> @enderror
                            <button type="button" class="btn btn-sm btn-primary mt-2" wire:click="addGalleryImages" wire:loading.attr="disabled">
                                <i class="fa fa-plus me-1"></i> Add to gallery
                            </button>
                        </div>
                        <div class="row g-2">
                            @foreach($galleryRoom->images as $img)
                                <div class="col-6 col-md-4">
                                    <div class="position-relative rounded border overflow-hidden">
                                        <img src="{{ asset($img->image_path) }}" alt="" class="img-fluid w-100" style="height: 120px; object-fit: cover;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" wire:click="removeGalleryImage({{ $img->id }})" onclick="return confirm('Remove this image?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($galleryRoom->images->isEmpty())
                            <p class="text-muted mb-0">No gallery images yet. Add images above.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeGalleryModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
