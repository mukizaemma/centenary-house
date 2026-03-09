@props(['title' => 'Page', 'header' => null, 'image' => null])
@php
    $displayTitle = $header && $header->title ? $header->title : $title;
    $caption = $header && $header->caption ? $header->caption : null;
    $backgroundImage = null;

    if ($header && $header->image_path) {
        $backgroundImage = asset($header->image_path);
    } elseif ($image) {
        $backgroundImage = asset($image);
    }
@endphp
<div class="locator-outer">
    <div class="locator">
        @if($backgroundImage)
            <img src="{{ $backgroundImage }}" alt="">
        @else
            <div class="locator-placeholder"></div>
        @endif
        <div class="locator-overlay"></div>
        <div class="locator-text">
            <h1 class="locator-title">{{ $displayTitle }}</h1>
            @if($caption)
                <p class="locator-caption">{{ $caption }}</p>
            @endif
        </div>
    </div>
</div>
