<div>
    <x-page-locator title="Space to Let" :header="$header ?? null" />
    <div class="content">
        <section class="spaces-page">
            <div class="spaces-header">
                <h2 class="section-heading">Available Spaces to Let</h2>
                <p class="section-sub">
                    Browse the currently available office and commercial spaces at Centenary House.
                </p>
            </div>

            @if($rooms->isEmpty())
                <p class="spaces-empty">There are no spaces available at the moment. Please check back soon.</p>
            @else
                <div class="spaces-grid">
                    @foreach($rooms as $room)
                        <article class="space-card">
                            <div class="space-card__cover">
                                @if($room->cover_image_path)
                                    <img src="{{ asset($room->cover_image_path) }}" alt="{{ $room->title }}">
                                @else
                                    <div class="space-card__cover-placeholder"></div>
                                @endif

                                @if(!$room->is_available)
                                    <span class="space-card__badge space-card__badge--unavailable">Unavailable</span>
                                @endif
                            </div>
                            <div class="space-card__body">
                                <div class="space-card__title-row">
                                    <h3 class="space-card__title">{{ $room->title }}</h3>
                                    @if($room->floor)
                                        <span class="space-card__floor-badge">{{ $room->floor }} Floor</span>
                                    @endif
                                </div>

                                <div class="space-card__meta">
                                    @if($room->square_meters !== null)
                                        <span>{{ number_format($room->square_meters, 0) }} m²</span>
                                    @endif
                                </div>

                                @php
                                    $usesPerSqm = $room->pricing_mode === 'per_sqm' && $room->square_meters && $room->amount_per_sqm;
                                    $hasCustom = $room->amount !== null;
                                @endphp

                                <div class="space-card__price-block">
                                    @if($usesPerSqm)
                                        @php
                                            $estimated = (float) $room->square_meters * (float) $room->amount_per_sqm;
                                        @endphp
                                        <div class="space-card__price">
                                            {{ number_format($estimated, 2) }}
                                        </div>
                                        <div class="space-card__price-note">
                                            Approx. per month ({{ number_format($room->amount_per_sqm, 2) }} per m²)
                                        </div>
                                    @elseif($hasCustom)
                                        <div class="space-card__price">
                                            {{ number_format($room->amount, 2) }}
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
                                    <a href="{{ route('space-to-let.show', $room->slug) }}"
                                       wire:navigate
                                       class="btn-primary space-card__button">
                                        View details &amp; request
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="spaces-legend">
                    <strong>Pricing note:</strong>
                    <span>
                        Some spaces are priced per m², while others use a custom monthly amount as configured.
                    </span>
                </div>
            @endif
        </section>
    </div>

    <style>
    .spaces-page {
        padding: 30px 0 40px;
    }

    .spaces-header {
        max-width: 780px;
        margin: 0 auto 32px;
        text-align: center;
    }

    .spaces-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
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

    .spaces-legend {
        margin-top: 24px;
        padding: 12px 16px;
        border-radius: 8px;
        background: #f9f9f9;
        font-size: 0.8rem;
        color: #666666;
    }

    .spaces-empty {
        font-size: 0.9rem;
        color: #666666;
    }

    @media (max-width: 992px) {
        .spaces-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .spaces-grid {
            grid-template-columns: 1fr;
        }

        .spaces-page {
            padding: 24px 0 32px;
        }
    }
    </style>
</div>

