<div>
    <x-page-locator title="Our Services" :header="$header ?? null" />
    <div class="content">
        <section class="services-page">
            <div class="services-intro">
                <h2 class="section-heading">Our Services</h2>
                <p class="section-sub">
                    Discover the key services available at Centenary House, designed to support modern businesses and professionals.
                </p>
            </div>

            @if($services->isEmpty())
                <p class="services-empty">No services are currently published. Please check back soon.</p>
            @else
                <div class="services-grid">
                    @foreach($services as $service)
                        <article class="service-card">
                            <div class="service-card__cover">
                                @if($service->cover_image)
                                    <img src="{{ asset($service->cover_image) }}" alt="{{ $service->title }}">
                                @else
                                    <div class="service-card__cover-placeholder"></div>
                                @endif
                            </div>
                            <div class="service-card__body">
                                <h3 class="service-card__title">{{ $service->title }}</h3>
                                @if($service->description)
                                    <div class="service-card__excerpt">
                                        {!! \Illuminate\Support\Str::limit(strip_tags($service->description), 160) !!}
                                    </div>
                                @endif
                                <a href="{{ route('public.services.show', $service->slug) }}"
                                   wire:navigate
                                   class="btn-primary service-card__button">
                                    View more
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <style>
    .services-page {
        padding: 30px 0 40px;
    }

    .services-intro {
        max-width: 720px;
        margin: 0 auto 32px;
        text-align: center;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .service-card {
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px -2px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .service-card__cover {
        height: 180px;
        background: #f5f5f5;
        overflow: hidden;
    }

    .service-card__cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
        display: block;
    }

    .service-card:hover .service-card__cover img {
        transform: scale(1.05);
    }

    .service-card__cover-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
    }

    .service-card__body {
        padding: 16px 18px 18px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex: 1;
    }

    .service-card__title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: var(--realblack);
    }

    .service-card__excerpt {
        font-size: 0.9rem;
        color: #555555;
        line-height: 1.6;
    }

    .service-card__button {
        margin-top: 8px;
        align-self: flex-start;
        opacity: 0.75;
        cursor: default;
    }

    .services-empty {
        font-size: 0.9rem;
        color: #666666;
    }

    @media (max-width: 992px) {
        .services-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .services-grid {
            grid-template-columns: 1fr;
        }

        .services-page {
            padding: 24px 0 32px;
        }
    }
    </style>
</div>

