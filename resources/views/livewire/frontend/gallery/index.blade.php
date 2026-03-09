<div>
<x-page-locator title="Gallery" :header="$header" />
<div class="content">
    <div class="gallery-page">
        <h2 class="section-heading">Our Gallery</h2>
        <p class="section-sub">Explore our facilities and moments</p>
        @if($items->isEmpty())
            <p class="text-muted">No gallery items yet.</p>
        @else
            <div class="gallery-grid">
                @foreach($items as $item)
                    <a href="{{ $item->image_path ? asset($item->image_path) : '#' }}" class="gallery-item" target="_blank" rel="noopener">
                        @if($item->image_path)
                            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title ?? 'Gallery' }}">
                        @endif
                        @if($item->title || $item->caption)
                            <div class="gallery-caption">
                                @if($item->title)<strong>{{ $item->title }}</strong>@endif
                                @if($item->caption)<span>{{ $item->caption }}</span>@endif
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
<style>
.gallery-page { padding: 30px 0; }
.gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
.gallery-item { display: block; border-radius: 8px; overflow: hidden; box-shadow: 0 0 20px -2px rgba(0,0,0,0.1); }
.gallery-item img { width: 100%; aspect-ratio: 4/3; object-fit: cover; }
.gallery-caption { padding: 12px; background: #f9f9f9; font-size: 0.85rem; }
.text-muted { color: #666; }
</style>
</div>
