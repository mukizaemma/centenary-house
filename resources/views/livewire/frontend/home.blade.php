<div>
    {{-- Slider: dynamic, smooth transitions, controls, captions, buttons --}}
    @if($sliders->isNotEmpty())
        <div class="hero-slider slider-fullwidth"
             x-data="{
                 current: 0,
                 total: {{ $sliders->count() }},
                 autoplayInterval: null,
                 startAutoplay() {
                     this.autoplayInterval = setInterval(() => {
                         this.current = (this.current + 1) % this.total;
                     }, 6000);
                 },
                 stopAutoplay() { clearInterval(this.autoplayInterval); },
                 next() { this.current = (this.current + 1) % this.total; this.stopAutoplay(); this.startAutoplay(); },
                 prev() { this.current = (this.current - 1 + this.total) % this.total; this.stopAutoplay(); this.startAutoplay(); }
             }"
             x-init="startAutoplay()"
             @mouseenter="stopAutoplay()"
             @mouseleave="startAutoplay()">
            <div class="hero-slider__wrap">
                @foreach($sliders as $i => $slide)
                    <div class="hero-slide"
                         x-show="current === {{ $i }}"
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0">
                        <div class="hero-slide__img-wrap">
                            <img src="{{ $slide->image_path ? asset($slide->image_path) : '' }}" alt="{{ $slide->title ?? 'Slide' }}" class="hero-slide__img" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                        </div>
                        <div class="hero-slide__overlay"></div>
                        <div class="hero-slide__content">
                            @if($slide->caption || $slide->title)
                                <div class="hero-slide__caption">{!! $slide->caption ?: e($slide->title) !!}</div>
                            @endif
                            @if($slide->button_text && $slide->button_url)
                                <a href="{{ $slide->button_url }}" class="hero-slide__btn"
                                   @if(str_starts_with($slide->button_url, 'http')) target="_blank" rel="noopener"
                                   @else wire:navigate @endif>
                                    {{ $slide->button_text }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Prev / Next controls --}}
            @if($sliders->count() > 1)
                <button type="button" class="hero-slider__btn hero-slider__btn--prev" @click="prev()" aria-label="Previous slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button type="button" class="hero-slider__btn hero-slider__btn--next" @click="next()" aria-label="Next slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="28" height="28"><path d="M9 18l6-6-6-6"/></svg>
                </button>

                {{-- Dot indicators --}}
                <div class="hero-slider__dots">
                    @foreach($sliders as $i => $slide)
                        <button type="button" class="hero-slider__dot" :class="{ 'hero-slider__dot--active': current === {{ $i }} }" @click="current = {{ $i }}; stopAutoplay(); startAutoplay();" aria-label="Go to slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <div class="content">

        {{-- About us section (scroll after slide) --}}
        @if($settings && ($settings->home_background_image_path || $settings->about_description || $settings->about_heading))
            <section class="welcome-section">
                <div class="about-medic">
                    @if($settings->home_background_image_path)
                        <div class="cover-img">
                            <img src="{{ asset($settings->home_background_image_path) }}" alt="About {{ $settings->company_name ?? 'Centenary House' }}">
                        </div>
                    @endif
                    <div class="about-medic-description">
                        <h3 class="heading">{{ $settings->about_heading ?? 'About ' . ($settings->company_name ?? 'Centenary House') }}</h3>
                        <div class="medic-description">
                            {!! $settings->about_description ?? $settings->home_background_text ?? '' !!}
                        </div>
                        <div class="welcome-actions">
                            <a href="{{ route('about') }}" wire:navigate class="btn-primary">
                                View more about us
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Services section (first 3 items in background-image card format) --}}
        @if(isset($services) && $services->count())
            @php
                $homeServices = $services->take(3);
            @endphp
            <section class="home-services">
                <div class="section-header">
                    <span class="about-label">OUR SERVICES</span>
                    <h3 class="section-heading">
                        Services available at {{ $settings->company_name ?? 'Centenary House' }}
                    </h3>
                    <p class="section-sub">
                        Discover the key services that support businesses and professionals within the building.
                    </p>
                </div>

                <div class="services-carousel-edge">
                    <div class="services-carousel swiper services-carousel--home">
                        <div class="swiper-wrapper">
                            @foreach($homeServices as $service)
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

                        <div class="swiper-button-prev services-carousel__btn services-carousel__btn--prev"></div>
                        <div class="swiper-button-next services-carousel__btn services-carousel__btn--next"></div>
                        <div class="swiper-pagination services-carousel__pagination"></div>
                    </div>
                </div>

                <div class="section-footer-link">
                    <a href="{{ route('public.services') }}" wire:navigate class="link-underlined">
                        View all services
                    </a>
                </div>
            </section>
        @endif

        {{-- Available office spaces / rooms --}}
        @if(isset($featuredRooms) && $featuredRooms->count())
            <section class="home-spaces">
                <div class="section-header">
                    <span class="about-label">OFFICE SPACES</span>
                    <h3 class="section-heading">
                        Available office spaces and rooms for rent
                    </h3>
                    <p class="section-sub">
                        Browse the spaces currently available and request the one that fits your needs.
                    </p>
                </div>

                <div class="spaces-grid">
                    @foreach($featuredRooms as $room)
                        @php
                            $usesPerSqm = $room->pricing_mode === 'per_sqm' && $room->square_meters && $room->amount_per_sqm;
                            $hasCustom = $room->amount !== null;
                            $shortDescription = \Illuminate\Support\Str::limit(strip_tags($room->description ?? ''), 130);
                        @endphp
                        <article class="space-card">
                            <div class="space-card__cover">
                                @if($room->cover_image_path)
                                    <img src="{{ asset($room->cover_image_path) }}" alt="{{ $room->title }}">
                                @else
                                    <div class="space-card__cover-placeholder"></div>
                                @endif
                            </div>
                            <div class="space-card__body">
                                <div class="space-card__title-row">
                                    <h3 class="space-card__title">{{ $room->title }}</h3>
                                    @if($room->floor)
                                        <span class="space-card__floor-badge">{{ $room->floor }} Floor</span>
                                    @endif
                                </div>

                                @if($shortDescription)
                                    <p class="space-card__excerpt">{{ $shortDescription }}</p>
                                @endif

                                <div class="space-card__meta">
                                    @if($room->square_meters !== null)
                                        <span>{{ number_format($room->square_meters, 0) }} m²</span>
                                    @endif
                                    @if($usesPerSqm)
                                        <span class="space-card__meta-separator">•</span>
                                        <span>From {{ number_format($room->amount_per_sqm, 2) }} per m²</span>
                                    @elseif($hasCustom)
                                        <span class="space-card__meta-separator">•</span>
                                        <span>Approx. {{ number_format($room->amount, 2) }} / month</span>
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

                <div class="section-footer-link">
                    <a href="{{ route('space-to-let') }}" wire:navigate class="link-underlined">
                        View all available spaces
                    </a>
                </div>
            </section>
        @endif

    </div>

    {{-- Background image + caption + call to action (before footer) --}}
    @if($settings && ($settings->home_background_image_path || $settings->home_background_text))
        <section class="home-background-cta">
            <div class="home-background-cta__bg"
                 @if($settings->home_background_image_path)
                     style="background-image: url('{{ asset($settings->home_background_image_path) }}');"
                 @endif>
            </div>
            <div class="home-background-cta__overlay"></div>
            <div class="home-background-cta__content">
                <div class="home-background-cta__inner">
                    @if($settings->home_background_text)
                        <div class="home-background-cta__caption">
                            {!! $settings->home_background_text !!}
                        </div>
                    @endif
                    <a href="{{ route('contact') }}" wire:navigate class="btn-primary home-background-cta__button">
                        Book your space
                    </a>
                </div>
            </div>
        </section>

        {{-- Call to action below background image: contacts left, office enquiry form right --}}
        <section class="home-cta-contact-enquiry">
            <div class="home-cta-contact-enquiry__inner">
                <div class="home-cta-contact-enquiry__col home-cta-contact-enquiry__col--contacts">
                    <h2 class="home-cta-contact-enquiry__title">Talk to us</h2>
                    <p class="home-cta-contact-enquiry__subtitle">
                        Get in touch for any questions about offices, parking or services at
                        {{ $settings->company_name ?? 'Centenary House' }}.
                    </p>

                    <div class="home-cta-contact-enquiry__contacts">
                        @if($settings->address)
                            <div class="home-cta-contact-enquiry__item">
                                <div class="home-cta-contact-enquiry__item-label">Address</div>
                                <div class="home-cta-contact-enquiry__item-value">
                                    {{ $settings->address }}
                                </div>
                            </div>
                        @endif
                        @if($settings->phone_reception || $settings->phone_urgency)
                            <div class="home-cta-contact-enquiry__item">
                                <div class="home-cta-contact-enquiry__item-label">Phone</div>
                                <div class="home-cta-contact-enquiry__item-value">
                                    @if($settings->phone_reception)
                                        <a href="tel:{{ $settings->phone_reception }}">{{ $settings->phone_reception }}</a>
                                    @endif
                                    @if($settings->phone_reception && $settings->phone_urgency)
                                        ·
                                    @endif
                                    @if($settings->phone_urgency)
                                        <a href="tel:{{ $settings->phone_urgency }}">{{ $settings->phone_urgency }}</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if($settings->email)
                            <div class="home-cta-contact-enquiry__item">
                                <div class="home-cta-contact-enquiry__item-label">Email</div>
                                <div class="home-cta-contact-enquiry__item-value">
                                    <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="home-cta-contact-enquiry__col home-cta-contact-enquiry__col--form">
                    @livewire('frontend.office-enquiry')
                </div>
            </div>
        </section>
    @endif

    <style>
/* Hero slider - full viewport, smooth transitions */
.slider-fullwidth { width: 100vw; position: relative; margin-left: calc(50% - 50vw); margin-right: calc(50% - 50vw); left: 0; box-sizing: border-box; margin-bottom: 30px; }
.hero-slider { position: relative; overflow: hidden; }
.hero-slider__wrap { position: relative; width: 100%; min-height: 50vh; height: 85vh; max-height: 900px; }
@media (max-width: 768px) { .hero-slider__wrap { min-height: 40vh; height: 70vh; } }
.hero-slide { position: absolute; inset: 0; width: 100%; height: 100%; }
.hero-slide__img-wrap { position: absolute; inset: 0; overflow: hidden; }
.hero-slide__img {
    width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;
    animation: heroZoom 12s ease-out infinite;
}
@keyframes heroZoom {
    0% { transform: scale(1.02); }
    100% { transform: scale(1.10); }
}
.hero-slide__overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.1) 50%, transparent 100%);
    pointer-events: none;
}
.hero-slide__content {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    padding: 0 60px;
    color: #fff;
    max-width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
@media (max-width: 768px) { .hero-slide__content { padding: 0 24px; } }
.hero-slide__caption {
    font-size: 2.25rem;
    font-weight: 700;
    line-height: 1.3;
    opacity: 0.98;
    margin-bottom: 24px;
    max-width: 720px;
    text-shadow: 0 2px 12px rgba(0,0,0,0.6);
    animation: heroFadeUp 0.6s ease-out;
}
.hero-slide__caption p { margin: 0 0 12px 0; font-size: inherit; font-weight: inherit; }
.hero-slide__caption p:last-child { margin-bottom: 0; }
@media (max-width: 768px) { .hero-slide__caption { font-size: 1.6rem; margin-bottom: 20px; } }
.hero-slide__btn {
    display: inline-flex; align-items: center; padding: 12px 28px;
    background: var(--primary); color: #fff !important;
    font-size: 0.95rem; font-weight: 600; text-decoration: none;
    border-radius: 8px; transition: background 0.3s, transform 0.2s;
}
.hero-slide__btn:hover { background: var(--primary-dark); transform: translateY(-2px); color: #fff !important; }

/* Prev/Next buttons */
.hero-slider__btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 52px; height: 52px; border-radius: 50%;
    background: rgba(255,255,255,0.2); color: #fff; border: none;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: background 0.3s, transform 0.2s;
    z-index: 10;
}
.hero-slider__btn:hover { background: rgba(255,255,255,0.35); transform: translateY(-50%) scale(1.05); }
.hero-slider__btn--prev { left: 24px; }
.hero-slider__btn--next { right: 24px; }
@media (max-width: 768px) {
    .hero-slider__btn { width: 44px; height: 44px; }
    .hero-slider__btn--prev { left: 12px; }
    .hero-slider__btn--next { right: 12px; }
    .hero-slider__btn svg { width: 22px; height: 22px; }
}

/* Dot indicators */
.hero-slider__dots {
    position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%);
    display: flex; gap: 10px; z-index: 10;
}
.hero-slider__dot {
    width: 10px; height: 10px; border-radius: 50%;
    background: rgba(255,255,255,0.5); border: none;
    cursor: pointer; padding: 0; transition: background 0.3s, transform 0.2s;
}
.hero-slider__dot:hover { background: rgba(255,255,255,0.8); }
.hero-slider__dot--active { background: var(--primary); transform: scale(1.2); }
@keyframes heroFadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.welcome-section { margin: 30px 0; }
.about-medic { display: grid; grid-template-columns: 1fr 1.2fr; column-gap: 40px; align-items: start; }
@media (max-width: 950px) { .about-medic { grid-template-columns: 1fr; } }
.cover-img { width: 100%; height: 400px; border-radius: 8px; overflow: hidden; }
.cover-img img { width: 100%; height: 100%; object-fit: cover; }
.about-medic-description .heading { font-size: 1.4rem; font-weight: 500; margin-bottom: 12px; }
.medic-description { font-size: 0.9rem; color: #555; line-height: 1.6; }
/* Shared section header used for services & spaces */
.section-header { text-align: center; max-width: 780px; margin: 26px auto 22px; }
.section-heading { font-size: 1.5rem; font-weight: 600; margin: 10px 0 6px; color: var(--realblack); }
.section-sub { font-size: 0.95rem; color: #666; margin: 0; }
.section-footer-link { margin-top: 18px; text-align: right; }
.link-underlined { font-size: 0.88rem; color: var(--primary); text-decoration: none; font-weight: 500; }
.link-underlined:hover { text-decoration: underline; }

/* Services cards (background-image cover) - stacked rows */
.home-services {
    margin: 10px 0 36px;
        padding: 26px 0 30px;
    background: #f2f0f1; /* subtle darkish background so page is not all white */
        border-radius: 0;
        width: 100vw;
        margin-left: 50%;
        transform: translateX(-50%);
}

.home-services-list {
    margin-top: 6px;
    display: flex;
    flex-direction: column;
    gap: 22px; /* spacing between rows */
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
    box-shadow: 0 0 18px -4px rgba(0,0,0,0.12);
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
    /* Ensure button is readable on the dark overlay */
    background: rgba(255,255,255,0.94) !important;
    color: #111 !important;
    border: none !important;
}

.services-bg-card .btn-primary:hover {
    background: rgba(255,255,255,1) !important;
}

@media (max-width: 600px) {
    .home-services {
        padding: 20px 0 24px;
    }
    .home-services-list { gap: 18px; }
    .services-bg-card {
        min-height: 60vh;
        height: 60vh;
    }
    .services-bg-card__content {
        padding: 18px 16px;
        gap: 8px;
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

/* Spaces / rooms */
.home-spaces { margin: 10px 0 40px; }
.spaces-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
.space-card { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 0 20px -2px rgba(0,0,0,0.08); display: flex; flex-direction: column; height: 100%; }
.space-card__cover { height: 230px; background: #f5f5f5; overflow: hidden; }
.space-card__cover img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s ease; }
.space-card:hover .space-card__cover img { transform: scale(1.05); }
.space-card__cover-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg,#f5f5f5,#e0e0e0); }
.space-card__body { padding: 16px 18px 18px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
.space-card__title-row { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; }
.space-card__title { font-size: 1rem; font-weight: 600; margin: 0; color: var(--realblack); }
.space-card__floor-badge { padding: 4px 8px; border-radius: 999px; background: #f5f5f5; font-size: 0.75rem; color: #555555; white-space: nowrap; }
.space-card__excerpt { font-size: 0.88rem; color: #555; line-height: 1.6; margin: 4px 0 0; }
.space-card__meta { font-size: 0.85rem; color: #666666; margin-top: 4px; }
.space-card__meta-separator { margin: 0 4px; color: #cccccc; }
.space-card__button-row { margin-top: 12px; }
.space-card__button { width: 100%; justify-content: center; }

@media (max-width: 1024px) {
    .spaces-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .spaces-grid {
        grid-template-columns: minmax(0, 1fr);
    }
}

/* CTA background using home background image */
.home-background-cta { position: relative; border-radius: 18px; overflow: hidden; min-height: 260px; margin: 12px 0 32px; }
.home-background-cta__bg { position: absolute; inset: 0; background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; }
.home-background-cta__overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(0,0,0,0.65), rgba(0,0,0,0.05)); }
.home-background-cta__content { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; padding: 34px 32px; text-align: center; }
.home-background-cta__inner { max-width: 640px; color: #ffffff; }
.home-background-cta__caption { font-size: 0.98rem; line-height: 1.8; margin-bottom: 14px; }
.home-background-cta__button { display: inline-flex; align-items: center; justify-content: center; }
@media (max-width: 768px) {
    .home-background-cta__bg { background-attachment: scroll; }
    .home-background-cta__content { padding: 26px 22px; }
}

/* CTA block below background image: contacts left, office enquiry form right */
.home-cta-contact-enquiry {
    margin: 0 0 40px;
}
.home-cta-contact-enquiry__inner {
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.2fr);
    gap: 24px;
    align-items: flex-start;
    padding: 24px 22px 26px;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}
.home-cta-contact-enquiry__title {
    font-size: 1.4rem;
    font-weight: 600;
    margin: 0 0 6px;
    color: var(--realblack);
}
.home-cta-contact-enquiry__subtitle {
    font-size: 0.95rem;
    color: #555;
    margin: 0 0 16px;
}
.home-cta-contact-enquiry__contacts {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.home-cta-contact-enquiry__item-label {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #888;
    margin-bottom: 2px;
}
.home-cta-contact-enquiry__item-value {
    font-size: 0.95rem;
    color: var(--realblack);
}
.home-cta-contact-enquiry__item-value a {
    color: var(--realblack);
    text-decoration: none;
}
.home-cta-contact-enquiry__item-value a:hover {
    color: var(--primary);
}

@media (max-width: 900px) {
    .home-cta-contact-enquiry__inner {
        grid-template-columns: 1fr;
    }
}

/* CTA Parallax section - full viewport width (edge-to-edge, matches hero slider) */
.cta-parallax--fullwidth {
    width: 100vw;
    max-width: 100vw;
    position: relative;
    left: 0;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    box-sizing: border-box;
}
.cta-parallax {
    position: relative;
    min-height: 420px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin: 48px 0;
}
.cta-parallax__bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
@media (max-width: 768px) {
    .cta-parallax__bg { background-attachment: scroll; background-position: center center; }
}
.cta-parallax__bg--fallback {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}
.cta-parallax__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.55);
    pointer-events: none;
}
.cta-parallax__content {
    position: relative;
    z-index: 2;
    width: 100%;
    padding: 48px 24px;
}
.cta-parallax__inner {
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
}
.cta-parallax__title {
    font-size: 2rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 20px 0;
    line-height: 1.3;
    text-shadow: 0 2px 12px rgba(0,0,0,0.5);
}
.cta-parallax__desc {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.95);
    line-height: 1.7;
    margin-bottom: 28px;
    width: 100%;
}
.cta-parallax__desc p { margin: 0 0 12px 0; }
.cta-parallax__desc p:last-child { margin-bottom: 0; }
.cta-parallax__contacts {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 28px 40px;
}
.cta-parallax__contact {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 24px;
    background: rgba(255,255,255,0.1);
    border-radius: 14px;
    text-decoration: none;
    transition: background 0.3s, transform 0.2s, box-shadow 0.3s;
    border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
}
.cta-parallax__contact:hover {
    background: rgba(255,255,255,0.18);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
}
.cta-parallax__icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary);
    color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(244,111,88,0.4);
    transition: background 0.2s, transform 0.2s;
}
.cta-parallax__contact:hover .cta-parallax__icon {
    background: var(--primary-dark);
    transform: scale(1.05);
}
.cta-parallax__icon svg { width: 24px; height: 24px; }
.cta-parallax__contact-text { display: flex; flex-direction: column; align-items: flex-start; gap: 2px; }
.cta-parallax__label {
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.8);
}
.cta-parallax__value {
    font-size: 1.15rem;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    transition: color 0.2s;
}
.cta-parallax__contact:hover .cta-parallax__value { color: #fff; }
.cta-parallax__btn {
    padding: 14px 32px;
    background: var(--primary);
    color: #fff !important;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    border-radius: 8px;
    transition: background 0.3s, transform 0.2s;
}
.cta-parallax__btn:hover { background: var(--primary-dark); transform: translateY(-2px); color: #fff !important; }
@media (max-width: 768px) {
    .cta-parallax { min-height: 380px; margin: 32px 0; }
    .cta-parallax__content { padding: 36px 20px; }
    .cta-parallax__title { font-size: 1.5rem; margin-bottom: 16px; }
    .cta-parallax__desc { font-size: 0.95rem; margin-bottom: 24px; }
    .cta-parallax__contacts { flex-direction: column; gap: 16px; }
    .cta-parallax__contact { width: 100%; max-width: 320px; margin: 0 auto; }
}
.text-center { text-align: center; }
.mt-4 { margin-top: 24px; }
    </style>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script>
            (function () {
                function initServicesHomeCarousel() {
                    const el = document.querySelector(".services-carousel--home");
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
                            nextEl: el.querySelector(".services-carousel__btn--next"),
                            prevEl: el.querySelector(".services-carousel__btn--prev"),
                        },
                        pagination: {
                            el: el.querySelector(".services-carousel__pagination"),
                            clickable: true,
                        },
                    });
                }

                if (document.readyState === "loading") {
                    document.addEventListener("DOMContentLoaded", initServicesHomeCarousel);
                } else {
                    initServicesHomeCarousel();
                }

                if (window.Livewire && typeof window.Livewire.hook === "function") {
                    window.Livewire.hook("message.processed", initServicesHomeCarousel);
                }
            })();
        </script>
    @endpush
</div>
