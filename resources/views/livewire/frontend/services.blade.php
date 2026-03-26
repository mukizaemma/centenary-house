<div>
    <x-page-locator title="Our Services" :header="$header ?? null" />
    <div class="content">
        @if($services->isEmpty())
            <section class="services-page">
                <div class="services-empty-panel">
                    <p class="services-empty">No services are currently published. Please check back soon.</p>
                </div>
            </section>
        @else
            <section class="services-listing">
                <div class="services-listing__inner">
                    <header class="services-listing__header">
                        <h2 class="services-listing__title">Our Services</h2>
                        <p class="services-listing__lead">
                            Discover the key services available at Centenary House, designed to support modern businesses and professionals.
                        </p>
                    </header>

                    <div class="services-grid">
                        @foreach($services as $service)
                            @php
                                $serviceSummary = \Illuminate\Support\Str::limit(strip_tags($service->description ?? ''), 140);
                            @endphp
                            <article class="services-grid__card">
                                @if($service->cover_image)
                                    <a href="{{ route('public.services.show', $service->slug) }}" wire:navigate class="services-grid__media">
                                        <img src="{{ asset($service->cover_image) }}" alt="" loading="lazy">
                                    </a>
                                @else
                                    <div class="services-grid__media services-grid__media--placeholder" aria-hidden="true">
                                        <span class="services-grid__placeholder-icon">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                        </span>
                                    </div>
                                @endif

                                <div class="services-grid__body">
                                    <h3 class="services-grid__card-title">
                                        <a href="{{ route('public.services.show', $service->slug) }}" wire:navigate>{{ $service->title }}</a>
                                    </h3>
                                    @if($serviceSummary)
                                        <p class="services-grid__excerpt">{{ $serviceSummary }}</p>
                                    @endif
                                    <a href="{{ route('public.services.show', $service->slug) }}"
                                       wire:navigate
                                        class="btn-primary services-grid__btn">
                                        View more
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

    <style>
    .services-page {
        padding: 32px 0 48px;
    }

    .services-empty-panel {
        max-width: 520px;
        margin: 0 auto;
        padding: 36px 28px;
        text-align: center;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.07);
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.02),
            0 16px 40px rgba(0, 0, 0, 0.07);
        position: relative;
        overflow: hidden;
    }

    .services-empty-panel::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #5c1304);
    }

    .services-empty {
        font-size: 0.95rem;
        color: #64748b;
        line-height: 1.65;
        margin: 0;
    }

    .services-listing {
        padding: 28px 0 56px;
        background: linear-gradient(180deg, #fafbfc 0%, #ffffff 28%, #ffffff 100%);
    }

    .services-listing__inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 22px;
    }

    .services-listing__header {
        text-align: center;
        max-width: 720px;
        margin: 0 auto 40px;
        padding: 8px 8px 0;
    }

    .services-listing__kicker {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.16em;
        margin-bottom: 10px;
    }

    .services-listing__title {
        margin: 0 0 14px;
        font-size: clamp(1.45rem, 2.8vw, 1.85rem);
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--realblack);
        line-height: 1.2;
        position: relative;
        padding-bottom: 10px;
    }

    .services-listing__title::after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 48px;
        height: 3px;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--primary), rgba(138, 29, 3, 0.35));
    }

    .services-listing__lead {
        margin: 16px 0 0;
        font-size: 0.96rem;
        color: #64748b;
        line-height: 1.7;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
    }

    .services-grid__card {
        position: relative;
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.07);
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.02),
            0 14px 36px rgba(0, 0, 0, 0.07);
        transition: box-shadow 0.22s ease, transform 0.22s ease, border-color 0.22s ease;
    }

    .services-grid__card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        z-index: 2;
        background: linear-gradient(90deg, var(--primary), #5c1304);
        opacity: 0.95;
    }

    .services-grid__card:hover {
        box-shadow:
            0 8px 12px rgba(0, 0, 0, 0.04),
            0 22px 48px rgba(0, 0, 0, 0.11);
        transform: translateY(-4px);
        border-color: rgba(138, 29, 3, 0.15);
    }

    .services-grid__media {
        display: block;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #ececec;
        position: relative;
    }

    .services-grid__media::after {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        box-shadow: inset 0 0 0 1px rgba(138, 29, 3, 0.06);
    }

    .services-grid__media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.45s ease;
    }

    @media (prefers-reduced-motion: no-preference) {
        .services-grid__card:hover .services-grid__media img {
            transform: scale(1.05);
        }
    }

    .services-grid__media--placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(145deg, var(--primary-light) 0%, #fafafa 55%, #f0ede8 100%);
    }

    .services-grid__placeholder-icon {
        color: rgba(138, 29, 3, 0.35);
    }

    .services-grid__body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 20px 20px 22px;
        gap: 12px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .services-grid__card-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 700;
        line-height: 1.3;
        letter-spacing: -0.01em;
    }

    .services-grid__card-title a {
        color: var(--realblack);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .services-grid__card-title a:hover {
        color: var(--primary);
    }

    .services-grid__excerpt {
        margin: 0;
        font-size: 0.9rem;
        color: #4b5563;
        line-height: 1.65;
        flex: 1;
    }

    .services-grid__btn {
        align-self: flex-start;
        margin-top: 4px;
        font-weight: 600;
        letter-spacing: 0.02em;
        padding: 10px 20px;
        box-shadow: 0 6px 18px rgba(138, 29, 3, 0.22);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .services-grid__btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 26px rgba(138, 29, 3, 0.3);
    }

    @media (max-width: 992px) {
        .services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .services-listing {
            padding: 20px 0 44px;
        }
        .services-listing__inner {
            padding: 0 16px;
        }
        .services-listing__header {
            margin-bottom: 28px;
        }
        .services-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
    </style>
</div>
