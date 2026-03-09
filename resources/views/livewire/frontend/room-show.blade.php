<div>
    @php
        $headerImagePath = $room->cover_image_path
            ? $room->cover_image_path
            : (($room->images && $room->images->count()) ? $room->images->first()->image_path : null);

        $initialImage = $room->cover_image_path
            ? asset($room->cover_image_path)
            : (($room->images && $room->images->count()) ? asset($room->images->first()->image_path) : null);
    @endphp

    <x-page-locator :title="$room->title" :image="$headerImagePath" />
    <div class="content">
        <section class="room-detail">
            <div class="room-detail__layout">
                <div class="room-detail__media"
                     @if($initialImage)
                         x-data="{ activeImage: '{{ $initialImage }}' }"
                     @endif
                >
                    @if($initialImage)
                        <div class="room-detail__cover">
                            <img :src="activeImage" alt="{{ $room->title }}">
                        </div>
                    @endif

                    @if($room->images && $room->images->count())
                        <div class="room-detail__gallery">
                            @foreach($room->images as $image)
                                @php
                                    $thumbSrc = asset($image->image_path);
                                @endphp
                                <button type="button"
                                        class="room-detail__thumb"
                                        x-on:click="activeImage = '{{ $thumbSrc }}'"
                                        x-bind:class="{ 'room-detail__thumb--active': activeImage === '{{ $thumbSrc }}' }">
                                    <img src="{{ $thumbSrc }}" alt="{{ $room->title }} image">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="room-detail__body">
                    <h1 class="room-detail__title">{{ $room->title }}</h1>

                    <div class="room-detail__meta">
                        @if($room->floor)
                            <span class="room-detail__meta-item">{{ $room->floor }} Floor</span>
                        @endif
                        @if($room->square_meters !== null)
                            <span class="room-detail__meta-separator">•</span>
                            <span class="room-detail__meta-item">{{ number_format($room->square_meters, 0) }} m²</span>
                        @endif
                    </div>

                    @php
                        $usesPerSqm = $room->pricing_mode === 'per_sqm' && $room->square_meters && $room->amount_per_sqm;
                        $hasCustom = $room->amount !== null;
                    @endphp
                    <div class="room-detail__price">
                        @if($usesPerSqm)
                            @php
                                $estimated = (float) $room->square_meters * (float) $room->amount_per_sqm;
                            @endphp
                            <div class="room-detail__price-main">
                                {{ number_format($estimated, 2) }}
                            </div>
                            <div class="room-detail__price-note">
                                Approx. per month ({{ number_format($room->amount_per_sqm, 2) }} per m²)
                            </div>
                        @elseif($hasCustom)
                            <div class="room-detail__price-main">
                                {{ number_format($room->amount, 2) }}
                            </div>
                            <div class="room-detail__price-note">
                                Custom monthly amount
                            </div>
                        @else
                            <div class="room-detail__price-main room-detail__price-main--pending">
                                Pricing on request
                            </div>
                        @endif
                    </div>

                    @if($room->description)
                        <div class="room-detail__description">
                            {!! $room->description !!}
                        </div>
                    @endif

                    <div class="room-detail__cta">
                        <a href="{{ route('contact', ['room' => $room->slug]) }}"
                           wire:navigate
                           class="btn-primary room-detail__cta-primary">
                            Request this space
                        </a>
                        <a href="{{ route('space-to-let') }}"
                           wire:navigate
                           class="room-detail__cta-secondary">
                            View all spaces
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="room-detail-enquiry">
            @livewire('frontend.room-enquiry-form', ['room' => $room])
        </section>

        @if(isset($otherRooms) && $otherRooms->isNotEmpty())
            <section class="room-detail-more">
                <div class="room-detail-more__header">
                    <h2 class="section-heading">More spaces you may like</h2>
                    <p class="section-sub">
                        Explore other offices and commercial spaces currently available at Centenary House.
                    </p>
                </div>

                <div class="room-detail-more__grid">
                    @foreach($otherRooms as $other)
                        <article class="space-card">
                            <div class="space-card__cover">
                                @if($other->cover_image_path)
                                    <img src="{{ asset($other->cover_image_path) }}" alt="{{ $other->title }}">
                                @else
                                    <div class="space-card__cover-placeholder"></div>
                                @endif

                                @if(!$other->is_available)
                                    <span class="space-card__badge space-card__badge--unavailable">Unavailable</span>
                                @endif
                            </div>
                            <div class="space-card__body">
                                <div class="space-card__title-row">
                                    <h3 class="space-card__title">{{ $other->title }}</h3>
                                    @if($other->floor)
                                        <span class="space-card__floor-badge">{{ $other->floor }} Floor</span>
                                    @endif
                                </div>

                                <div class="space-card__meta">
                                    @if($other->square_meters !== null)
                                        <span>{{ number_format($other->square_meters, 0) }} m²</span>
                                    @endif
                                </div>

                                @php
                                    $usesPerSqm = $other->pricing_mode === 'per_sqm' && $other->square_meters && $other->amount_per_sqm;
                                    $hasCustom = $other->amount !== null;
                                @endphp

                                <div class="space-card__price-block">
                                    @if($usesPerSqm)
                                        @php
                                            $estimated = (float) $other->square_meters * (float) $other->amount_per_sqm;
                                        @endphp
                                        <div class="space-card__price">
                                            {{ number_format($estimated, 2) }}
                                        </div>
                                        <div class="space-card__price-note">
                                            Approx. per month ({{ number_format($other->amount_per_sqm, 2) }} per m²)
                                        </div>
                                    @elseif($hasCustom)
                                        <div class="space-card__price">
                                            {{ number_format($other->amount, 2) }}
                                        </div>
                                        <div class="space-card__price-note">
                                            Custom monthly amount
                                        </div>
                                    @else
                                        <div class="space-card__price space-card__price--pending">
                                            Pricing on request
                                        </div>
                                    @endif
                                </div>

                                <div class="space-card__button-row">
                                    <a href="{{ route('space-to-let.show', $other->slug) }}"
                                       wire:navigate
                                       class="btn-primary space-card__button">
                                        View details &amp; request
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <style>
    .room-detail {
        padding: 0 0 40px;
        margin-top: -90px;
        position: relative;
        z-index: 2;
    }

    .room-detail__layout {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(0, 1.4fr);
        gap: 30px;
        align-items: flex-start;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.16);
        padding: 22px 24px 24px;
        transform: translateY(-20px);
    }

    @media (max-width: 900px) {
        .room-detail__layout {
            grid-template-columns: 1fr;
        }
    }

    .room-detail__media {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .room-detail__cover {
        border-radius: 14px;
        overflow: hidden;
        background: #f5f5f5;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
    }

    .room-detail__cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .room-detail__gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 8px;
    }

    .room-detail__thumb {
        border-radius: 8px;
        overflow: hidden;
        background: #f5f5f5;
        padding: 0;
        border: 2px solid transparent;
        cursor: pointer;
        transition: border-color 0.2s ease, transform 0.15s ease;
    }

    .room-detail__thumb:hover {
        transform: translateY(-1px);
    }

    .room-detail__thumb--active {
        border-color: var(--primary);
    }

    .room-detail__thumb img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        display: block;
    }

    .room-detail__title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 6px;
        color: var(--realblack);
    }

    .room-detail__meta {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 10px;
    }

    .room-detail__meta-item {
        display: inline-block;
    }

    .room-detail__meta-separator {
        margin: 0 4px;
        color: #ccc;
    }

    .room-detail__price {
        margin-bottom: 14px;
    }

    .room-detail__price-main {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--realblack);
    }

    .room-detail__price-main--pending {
        color: #888;
    }

    .room-detail__price-note {
        font-size: 0.85rem;
        color: #777;
        margin-top: 2px;
    }

    .room-detail__description {
        font-size: 0.95rem;
        color: #555;
        line-height: 1.8;
    }

    .room-detail__description p {
        margin-bottom: 1em;
    }

    .room-detail__cta {
        margin-top: 22px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .room-detail__cta-primary {
        justify-content: center;
        min-width: 190px;
    }

    .room-detail__cta-secondary {
        font-size: 0.85rem;
        font-weight: 500;
        color: #555;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .room-detail__cta-secondary::after {
        content: '›';
        font-size: 0.9rem;
        color: var(--primary);
    }

    .room-detail-enquiry {
        margin-top: -8px;
    }

    .room-detail-more {
        margin-top: 40px;
        padding-bottom: 10px;
    }

    .room-detail-more__header {
        max-width: 740px;
        margin: 0 auto 26px;
        text-align: center;
    }

    .room-detail-more__grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .space-card {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 0 20px -2px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .space-card__cover {
        position: relative;
        height: 190px;
        background: #f5f5f5;
        overflow: hidden;
    }

    .space-card__cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .space-card:hover .space-card__cover img {
        transform: scale(1.05);
    }

    .space-card__cover-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
    }

    .space-card__badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(0, 0, 0, 0.65);
        color: #ffffff;
    }

    .space-card__badge--unavailable {
        background: #fef3c7;
        color: #92400e;
    }

    .space-card__body {
        padding: 16px 18px 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .space-card__title-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 8px;
    }

    .space-card__title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: var(--realblack);
    }

    .space-card__floor-badge {
        padding: 4px 8px;
        border-radius: 999px;
        background: #f5f5f5;
        font-size: 0.75rem;
        color: #555555;
        white-space: nowrap;
    }

    .space-card__meta {
        font-size: 0.85rem;
        color: #666666;
    }

    .space-card__price-block {
        margin-top: 4px;
    }

    .space-card__price {
        font-size: 0.98rem;
        font-weight: 600;
        color: var(--realblack);
    }

    .space-card__price--pending {
        color: #888888;
        font-weight: 500;
    }

    .space-card__price-note {
        margin-top: 2px;
        font-size: 0.8rem;
        color: #777777;
    }

    .space-card__button-row {
        margin-top: 12px;
    }

    .space-card__button {
        width: 100%;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .room-detail {
            margin-top: -60px;
        }

        .room-detail__layout {
            grid-template-columns: 1fr;
            padding: 18px 18px 20px;
        }

        .room-detail-more__grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .room-detail {
            margin-top: -40px;
        }

        .room-detail__layout {
            transform: translateY(-10px);
            padding: 16px 14px 18px;
        }

        .room-detail-more__grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</div>

