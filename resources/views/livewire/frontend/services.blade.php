<div>
    <x-page-locator title="Our Services" :header="$header ?? null" />
    <div class="content">
        @if($services->isEmpty())
            <section class="services-page">
                <p class="services-empty">No services are currently published. Please check back soon.</p>
            </section>
        @else
            @php
                $previewServices = $services->take(3);
                $remainingServices = $services->slice(3);

                $firstCover = $previewServices->first()?->cover_image;
                $bgImage = $settings?->home_background_image_path
                    ? asset($settings->home_background_image_path)
                    : ($firstCover ? asset($firstCover) : null);
            @endphp

            {{-- Full-width parallax background wrapper --}}
            <section
                class="services-hero"
                @if($bgImage)
                    style="background-image: url('{{ $bgImage }}');"
                @endif
            >
                <div class="services-hero__overlay"></div>

                <div class="services-hero__inner">
                    <header class="services-hero__header">
                        <span class="services-kicker">OUR SERVICES</span>
                        <h2 class="section-heading services-hero__title">Our Services</h2>
                        <p class="services-lead">
                            Discover the key services available at Centenary House, designed to support modern businesses and professionals.
                        </p>
                    </header>

                    <div class="services-carousel-edge">
                        <div class="services-carousel swiper services-carousel--preview">
                            <div class="swiper-wrapper">
                                @foreach($previewServices as $service)
                                    @php
                                        $serviceSummary = \Illuminate\Support\Str::limit(strip_tags($service->description ?? ''), 110);
                                    @endphp
                                    <div class="swiper-slide">
                                        <article
                                            class="service-card services-bg-card {{ $service->cover_image ? '' : 'services-bg-card--no-image' }}"
                                            @if($service->cover_image)
                                                style="background-image: url('{{ asset($service->cover_image) }}');"
                                            @endif
                                        >
                                            <div class="services-bg-card__content">
                                                <h3 class="services-bg-card__title">{{ $service->title }}</h3>

                                                @if($serviceSummary)
                                                    <p class="services-bg-card__excerpt">{{ $serviceSummary }}</p>
                                                @endif

                                                <a href="{{ route('public.services.show', $service->slug) }}"
                                                   wire:navigate
                                                   class="btn-primary services-bg-card__button">
                                                    View more
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>

                            <div class="swiper-button-prev services-carousel__btn services-carousel__btn--preview-prev"></div>
                            <div class="swiper-button-next services-carousel__btn services-carousel__btn--preview-next"></div>
                            <div class="swiper-pagination services-carousel__pagination services-carousel__pagination--preview"></div>
                        </div>
                    </div>

                    @if($remainingServices->count())
                        <div class="services-preview-footer">
                            <a href="#services-all" class="btn-primary services-view-all">
                                View all services
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            @if($remainingServices->count())
                <section id="services-all" class="services-all">
                    <div class="services-all__inner">
                        <div class="services-carousel-edge">
                            <div class="services-carousel swiper services-carousel--all">
                                <div class="swiper-wrapper">
                                    @foreach($remainingServices as $service)
                                        @php
                                            $serviceSummary = \Illuminate\Support\Str::limit(strip_tags($service->description ?? ''), 110);
                                        @endphp
                                        <div class="swiper-slide">
                                            <article
                                                class="service-card services-bg-card {{ $service->cover_image ? '' : 'services-bg-card--no-image' }}"
                                                @if($service->cover_image)
                                                    style="background-image: url('{{ asset($service->cover_image) }}');"
                                                @endif
                                            >
                                                <div class="services-bg-card__content">
                                                    <h3 class="services-bg-card__title">{{ $service->title }}</h3>

                                                    @if($serviceSummary)
                                                        <p class="services-bg-card__excerpt">{{ $serviceSummary }}</p>
                                                    @endif

                                                    <a href="{{ route('public.services.show', $service->slug) }}"
                                                       wire:navigate
                                                       class="btn-primary services-bg-card__button">
                                                        View more
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="swiper-button-prev services-carousel__btn services-carousel__btn--all-prev"></div>
                                <div class="swiper-button-next services-carousel__btn services-carousel__btn--all-next"></div>
                                <div class="swiper-pagination services-carousel__pagination services-carousel__pagination--all"></div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endif
    </div>

    <style>
    .services-page { padding: 36px 0 40px; }

    .services-hero {
        position: relative;
        width: 100vw;
        padding: 56px 0 44px;
        border-radius: 0;
        margin-left: 50%;
        transform: translateX(-50%);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed; /* parallax-like look */
        overflow: hidden;
    }

    .services-hero__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0,0,0,0.65), rgba(0,0,0,0.10));
    }

    .services-hero__inner {
        position: relative;
        z-index: 1;
        max-width: 100%;
        margin: 0 auto;
    padding: 0;
    }

    .services-hero__header {
        text-align: center;
        margin-bottom: 26px;
        color: #ffffff;
    padding: 0 22px;
    }

    .services-kicker {
        display: inline-block;
        font-size: 0.85rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.95);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 10px;
    }

    .services-hero__title { color: #ffffff; }

    .services-lead {
        max-width: 820px;
        margin: 10px auto 0;
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.86);
        line-height: 1.8;
    }

    .services-preview-list {
        margin-top: 18px;
        display: flex;
        flex-direction: column;
        gap: 22px; /* spacing between rows */
    }

    .services-preview-footer {
        margin-top: 18px;
        text-align: center;
    }

    .services-view-all {
        background: rgba(255,255,255,0.94) !important;
        color: #111 !important;
        border: none !important;
        display: inline-flex;
    }

    .services-all {
        padding: 34px 0 60px;
        background: #f2f0f1;
        width: 100vw;
        border-radius: 0;
        margin-left: 50%;
        transform: translateX(-50%);
    }

    .services-all__inner {
        max-width: 100%;
        margin: 0 auto;
    padding: 0;
    }

    .services-all-list {
        display: flex;
        flex-direction: column;
        gap: 22px;
    }

    .services-bg-card {
        position: relative;
        border-radius: 0;
        overflow: hidden;
        width: 100%;
        min-height: 100vh;
        height: 100vh;
        background: #e9e9e9;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        box-shadow: 0 0 18px -4px rgba(0, 0, 0, 0.12);
    }

    .services-bg-card::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.25) 55%, rgba(0,0,0,0.05) 100%);
    }

    .services-bg-card--no-image {
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
    }

    .services-bg-card__content {
        position: absolute;
        inset: 0;
        z-index: 1;
        display: flex;
        flex-direction: column;
    justify-content: flex-end;
        align-items: center;
        text-align: center;
    padding: 26px 22px 32px;
        gap: 10px;
        color: #ffffff;
    }

    .services-bg-card__title {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 650;
    }

    .services-bg-card__excerpt {
        margin: 0;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.88);
        line-height: 1.6;
    }

    .services-bg-card__button {
        margin-top: 6px;
        align-self: center;
    }

    .services-bg-card .btn-primary {
        background: rgba(255,255,255,0.94) !important;
        color: #111 !important;
        border: none !important;
    }

    .services-bg-card .btn-primary:hover {
        background: rgba(255,255,255,1) !important;
    }

    .services-empty {
        font-size: 0.9rem;
        color: #666666;
        text-align: center;
        padding: 30px 0;
    }

    @media (max-width: 992px) {
        /* stacked rows - no grid changes needed */
    }

    @media (max-width: 768px) {
        .services-hero {
            background-attachment: scroll; /* mobile-friendly */
            padding: 38px 0 30px;
        }
        .services-hero__inner { padding: 0 16px; }
        .services-all__inner { padding: 0 16px; }
        .services-preview-list,
        .services-all-list { gap: 18px; }

        .services-bg-card {
            min-height: 60vh;
            height: 60vh;
        }
    }

    /* Services carousel (edge-to-edge) */
    .services-carousel-edge {
        width: 100%;
        margin-left: 0;
        transform: none;
    }

    .services-carousel {
        width: 100%;
    }

    .services-carousel {
        position: relative;
    }

    .services-carousel .swiper-wrapper {
        width: 100%;
    }

    .services-carousel .swiper-slide {
        width: 100% !important;
        display: flex;
    }

    .services-carousel__btn {
        color: #fff;
    }

    .services-carousel__pagination .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.7);
    }

    .services-carousel__pagination .swiper-pagination-bullet-active {
        background: #ffffff;
    }

    .services-carousel__pagination {
        position: absolute;
        bottom: 26px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 50;
        display: flex;
        justify-content: center;
    }

    .services-carousel__pagination .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        margin: 0 6px !important;
        opacity: 1;
    }
    </style>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script>
            (function () {
                function initServicesCarousel(containerSelector, navPrevClass, navNextClass, paginationClass) {
                    const el = document.querySelector(containerSelector);
                    if (!el || !window.Swiper) return;
                    if (el.dataset.inited === "1") return;
                    el.dataset.inited = "1";

                    const slidesCount = el.querySelectorAll(".swiper-slide").length;

                    new Swiper(el, {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        loop: slidesCount > 1,
                        speed: 800,
                        navigation: {
                            prevEl: el.querySelector(navPrevClass),
                            nextEl: el.querySelector(navNextClass),
                        },
                        pagination: {
                            el: el.querySelector(paginationClass),
                            clickable: true,
                        },
                    });
                }

                function initAll() {
                    initServicesCarousel(
                        ".services-carousel--preview",
                        ".services-carousel__btn--preview-prev",
                        ".services-carousel__btn--preview-next",
                        ".services-carousel__pagination--preview"
                    );

                    initServicesCarousel(
                        ".services-carousel--all",
                        ".services-carousel__btn--all-prev",
                        ".services-carousel__btn--all-next",
                        ".services-carousel__pagination--all"
                    );
                }

                if (document.readyState === "loading") {
                    document.addEventListener("DOMContentLoaded", initAll);
                } else {
                    initAll();
                }

                if (window.Livewire && typeof window.Livewire.hook === "function") {
                    window.Livewire.hook("message.processed", initAll);
                }
            })();
        </script>
    @endpush
</div>

