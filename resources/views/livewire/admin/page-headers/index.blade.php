@section('title', 'Page Headers')

<div>
    <div class="bg-light rounded p-4">
        <h4 class="mb-4">Page Headers</h4>

        <p class="text-muted mb-3">
            Configure the hero image, title, and short caption for each public page. These are used by the
            <code>&lt;x-page-locator&gt;</code> component at the top of the page.
        </p>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Page</label>
                    <select class="form-select @error('page_key') is-invalid @enderror" wire:model="page_key">
                        @foreach($pageOptions as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('page_key')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Header Title</label>
                    <input type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           wire:model.defer="title"
                           placeholder="Displayed large in the hero area">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Caption (short text under title)</label>
                    <input type="text"
                           class="form-control @error('caption') is-invalid @enderror"
                           wire:model.defer="caption"
                           placeholder="Optional short description">
                    @error('caption')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Header Background Image</label>
                    <input type="file"
                           class="form-control @error('image') is-invalid @enderror"
                           wire:model="image"
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($image)
                        <div class="mt-3">
                            <span class="text-muted small d-block mb-1">Preview (new upload):</span>
                            <img src="{{ $image->temporaryUrl() }}" alt="Header preview" class="img-fluid rounded border" style="max-height: 200px;">
                        </div>
                    @elseif($image_path)
                        <div class="mt-3">
                            <span class="text-muted small d-block mb-1">Current image:</span>
                            <img src="{{ asset($image_path) }}" alt="Current header" class="img-fluid rounded border" style="max-height: 200px;">
                        </div>
                    @endif
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <p class="text-muted small mb-0">
                        Recommended aspect ratio similar to your page hero banners (wide image).
                        If no image is set, a gradient placeholder will be shown instead.
                    </p>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-2"></i>Save Header
            </button>
        </form>
    </div>
</div>

