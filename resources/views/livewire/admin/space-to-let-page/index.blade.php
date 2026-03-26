@section('title', 'Space to Let Page')

<div>
    <div class="bg-light rounded p-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
                <h4 class="mb-1">Space to Let page content</h4>
                <small class="text-muted">Edit what appears above the listings on the public Space to Let page.</small>
            </div>
            <button class="btn btn-sm btn-primary" wire:click="save">
                <i class="fa fa-save me-1"></i> Save changes
            </button>
        </div>

        <div class="row g-3">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">1) Value proposition (top section)</h6>

                        <div class="mb-3">
                            <label class="form-label">Headline</label>
                            <input type="text" class="form-control" wire:model.defer="hero_title">
                            @error('hero_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub-headline</label>
                            <textarea class="form-control" rows="2" wire:model.defer="hero_subtitle"></textarea>
                            @error('hero_subtitle') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Key points (one per line)</label>
                            <textarea class="form-control" rows="4" wire:model.defer="hero_bullets_text"></textarea>
                            @error('hero_bullets_text') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">2) Location & accessibility</h6>

                        <div class="mb-3">
                            <label class="form-label">Section title</label>
                            <input type="text" class="form-control" wire:model.defer="location_title">
                            @error('location_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content (optional)</label>
                            <textarea class="form-control summernote" wire:model.defer="location_html" rows="5"></textarea>
                            @error('location_html') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Google Maps embed URL (optional)</label>
                            <input type="text" class="form-control" wire:model.defer="google_map_embed_url" placeholder="https://www.google.com/maps/embed?...">
                            @error('google_map_embed_url') <small class="text-danger">{{ $message }}</small> @enderror
                            <small class="text-muted d-block mt-1">Paste an embed URL, not a normal maps share link.</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3 mb-0">
                    <strong>Types of spaces</strong> and <strong>Testimonials</strong> are now managed from their own admin pages:
                    <span class="d-block mt-1">
                        <a href="{{ route('admin.space-types.index') }}">Space Types</a> and
                        <a href="{{ route('admin.space-testimonials.index') }}">Space Testimonials</a>.
                    </span>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">4) Amenities & features</h6>
                        <label class="form-label">Amenities (one per line)</label>
                        <textarea class="form-control" rows="8" wire:model.defer="amenities_text"></textarea>
                        @error('amenities_text') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">5) Visuals</h6>
                        <label class="form-label">Upload images (optional)</label>
                        <input class="form-control" type="file" multiple accept="image/*" wire:model="gallery">
                        @error('gallery.*') <small class="text-danger">{{ $message }}</small> @enderror

                        @if(!empty($existing_gallery_images))
                            <div class="mt-3">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($existing_gallery_images as $i => $img)
                                        <div class="border rounded p-1">
                                            <img src="{{ asset($img) }}" alt="" style="height:54px;width:auto;display:block;">
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0 mt-1" wire:click="removeGalleryImage({{ $i }})">
                                                Remove
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted d-block mt-1">Removed images will be unlinked after you save.</small>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">6) Pricing & call-to-action</h6>

                        <div class="mb-3">
                            <label class="form-label">Pricing note (optional)</label>
                            <textarea class="form-control summernote" wire:model.defer="pricing_html" rows="5"></textarea>
                            @error('pricing_html') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Primary CTA button text</label>
                            <input type="text" class="form-control" wire:model.defer="cta_primary_text">
                            @error('cta_primary_text') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Primary CTA button URL</label>
                            <input type="text" class="form-control" wire:model.defer="cta_primary_url">
                            @error('cta_primary_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="mb-3">7) Optional sections</h6>

                        <div class="mb-3">
                            <label class="form-label">Who it’s ideal for (one per line)</label>
                            <textarea class="form-control" rows="4" wire:model.defer="ideal_for_text"></textarea>
                            @error('ideal_for_text') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" wire:model.defer="is_active">
                            <label class="form-check-label">Enable this content on the public page</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary" wire:click="save">
                        <i class="fa fa-save me-1"></i> Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

