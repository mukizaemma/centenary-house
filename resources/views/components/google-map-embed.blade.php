@props([
    'embed' => null,
    'title' => 'Location map',
    'minHeight' => 320,
    'emptyMessage' => null,
])

@php
    $mapUrl = $embed;
    if ($mapUrl && is_string($mapUrl) && preg_match('/src=["\']([^"\']+)["\']/', $mapUrl, $m)) {
        $mapUrl = $m[1];
    }
    $mapUrl = $mapUrl ? trim((string) $mapUrl) : null;
    $minH = max(120, (int) $minHeight);
@endphp

@if($mapUrl)
    <div {{ $attributes->merge(['class' => 'site-map-embed']) }} style="min-height: {{ $minH }}px;">
        <iframe
            src="{{ $mapUrl }}"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
            title="{{ $title }}"
        ></iframe>
    </div>
@elseif($emptyMessage !== null && $emptyMessage !== '')
    <div {{ $attributes->merge(['class' => 'site-map-embed site-map-embed--empty']) }} style="min-height: {{ $minH }}px;">
        <p>{{ $emptyMessage }}</p>
    </div>
@endif
