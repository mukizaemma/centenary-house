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
            <section class="welcome-section about-home">
                <div class="about-medic">
                    @if($settings->home_background_image_path)
                        <div class="cover-img about-medic__media">
                            <img src="{{ asset($settings->home_background_image_path) }}" alt="About {{ $settings->company_name ?? 'Centenary House' }}" loading="lazy">
                        </div>
                    @endif
                    <div class="about-medic-description about-medic__content">
                        <span class="about-home__kicker">About us</span>
                        <h3 class="heading about-medic__title">{{ $settings->about_heading ?? 'About ' . ($settings->company_name ?? 'Centenary House') }}</h3>
                        <div class="medic-description about-medic__body">
                            {!! $settings->about_description ?? $settings->home_background_text ?? '' !!}
                        </div>
                        <div class="welcome-actions">
                            <a href="{{ route('about') }}" wire:navigate class="btn-primary about-medic__cta">
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

        {{-- Types of spaces available --}}
        @if(isset($spaceTypes) && $spaceTypes->count())
            <section class="home-space-types">
                <div class="section-header">
                    <h3 class="section-heading">Types of spaces available</h3>
                    <p class="section-sub">Choose a workspace type and request the option that fits your needs.</p>
                </div>

                <div class="space-types-grid">
                    @foreach($spaceTypes as $type)
                        @php
                            $descPlain = strip_tags($type->description ?? '');
                            $descExcerpt = \Illuminate\Support\Str::limit($descPlain, 150);
                        @endphp
                        <article class="space-type-card">
                            <div class="space-type-card__top">
                                <h4 class="space-type-card__title">{{ $type->title }}</h4>
                                @if(!empty($type->starting_price))
                                    <span class="space-type-card__price">From {{ $type->starting_price }}</span>
                                @endif
                            </div>

                            @if(!empty($descExcerpt))
                                <p class="space-type-card__desc">{{ $descExcerpt }}</p>
                            @endif

                            <div class="space-type-card__actions">
                                <a href="{{ route('book-tour-visit', ['type' => $type->id]) }}"
                                   wire:navigate
                                   class="btn-primary space-type-card__button">
                                    Book a Tour Visit
                                </a>
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
                    <h2 class="home-background-cta__quote">
                        "Centenary House is where ambitious businesses grow with confidence, flexibility, and a professional address in the heart of Kigali."
                    </h2>
                    <div class="home-background-cta__details">
                        <div class="home-background-cta__panel home-background-cta__panel--features">
                            <div class="home-background-cta__feature-tags" role="list" aria-label="Key space highlights">
                                <span class="home-background-cta__tag" role="listitem">Prime location in Kigali</span>
                                <span class="home-background-cta__tag" role="listitem">Flexible offices (private to full floor)</span>
                                <span class="home-background-cta__tag" role="listitem">Professional environment</span>
                                <span class="home-background-cta__tag" role="listitem">Accessibility and secure parking</span>
                            </div>
                        </div>

                        <div class="home-background-cta__panel home-background-cta__panel--audience">
                            <div class="home-background-cta__audience-title">
                                <span class="home-background-cta__audience-icon" aria-hidden="true">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6"/><path d="M23 11h-6"/></svg>
                                </span>
                                <span>Who it's ideal for</span>
                            </div>
                            <div class="home-background-cta__audience-chips" role="list" aria-label="Best fit businesses">
                                <span class="home-background-cta__chip" role="listitem">Startups</span>
                                <span class="home-background-cta__chip" role="listitem">NGOs</span>
                                <span class="home-background-cta__chip" role="listitem">Corporate offices</span>
                                <span class="home-background-cta__chip" role="listitem">Consultants</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Call to action below background image: contacts left, office enquiry form right --}}
        <section class="home-cta-contact-enquiry">
            <div class="home-cta-contact-enquiry__inner">
                <div class="home-cta-contact-enquiry__col home-cta-contact-enquiry__col--contacts">
                    <div class="home-cta-contact-enquiry__panel">
                        <span class="home-cta-contact-enquiry__kicker">Contact</span>
                        <h2 class="home-cta-contact-enquiry__title">Talk to us</h2>
                        <p class="home-cta-contact-enquiry__subtitle">
                            Get in touch for any questions about offices, parking or services at
                            {{ $settings->company_name ?? 'Centenary House' }}.
                        </p>

                        <div class="home-cta-contact-enquiry__contacts">
                            @if($settings->address)
                                <div class="home-cta-contact-enquiry__card">
                                    <div class="home-cta-contact-enquiry__card-icon" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    </div>
                                    <div class="home-cta-contact-enquiry__card-body">
                                        <div class="home-cta-contact-enquiry__item-label">Address</div>
                                        <div class="home-cta-contact-enquiry__item-value home-cta-contact-enquiry__address">
                                            {!! $settings->address !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($settings->phone_reception || $settings->phone_urgency)
                                <div class="home-cta-contact-enquiry__card">
                                    <div class="home-cta-contact-enquiry__card-icon" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    </div>
                                    <div class="home-cta-contact-enquiry__card-body">
                                        <div class="home-cta-contact-enquiry__item-label">Phone</div>
                                        <div class="home-cta-contact-enquiry__item-value">
                                            @if($settings->phone_reception)
                                                <a href="tel:{{ $settings->phone_reception }}">{{ $settings->phone_reception }}</a>
                                            @endif
                                            @if($settings->phone_reception && $settings->phone_urgency)
                                                <span class="home-cta-contact-enquiry__sep">·</span>
                                            @endif
                                            @if($settings->phone_urgency)
                                                <a href="tel:{{ $settings->phone_urgency }}">{{ $settings->phone_urgency }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($settings->email)
                                <div class="home-cta-contact-enquiry__card">
                                    <div class="home-cta-contact-enquiry__card-icon" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    </div>
                                    <div class="home-cta-contact-enquiry__card-body">
                                        <div class="home-cta-contact-enquiry__item-label">Email</div>
                                        <div class="home-cta-contact-enquiry__item-value">
                                            <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
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
.welcome-section.about-home {
    margin: 36px 0 44px;
    padding: 8px 0 12px;
}
.about-medic {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.15fr);
    column-gap: clamp(28px, 5vw, 56px);
    row-gap: 28px;
    align-items: center;
}
@media (max-width: 950px) {
    .about-medic { grid-template-columns: 1fr; }
}
.cover-img {
    width: 100%;
    min-height: 280px;
    height: auto;
    aspect-ratio: 4 / 3;
    max-height: 440px;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    box-shadow:
        0 4px 6px rgba(0, 0, 0, 0.04),
        0 20px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.06);
}
.cover-img::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: inherit;
    pointer-events: none;
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
}
.cover-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.6s ease;
}
@media (prefers-reduced-motion: no-preference) {
    .about-medic__media:hover img {
        transform: scale(1.03);
    }
}
.about-medic__content {
    position: relative;
    padding: 8px 0 8px 22px;
}
.about-medic__content::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0.25rem;
    bottom: 3rem;
    width: 4px;
    border-radius: 4px;
    background: linear-gradient(180deg, var(--primary), #5c1304);
    opacity: 0.9;
}
@media (max-width: 950px) {
    .about-medic__content {
        padding-left: 0;
    }
    .about-medic__content::before {
        display: none;
    }
}
.about-home__kicker {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--primary);
    margin-bottom: 10px;
}
.about-medic__title.heading,
.about-medic-description .about-medic__title {
    font-size: clamp(1.45rem, 2.6vw, 1.85rem);
    font-weight: 700;
    line-height: 1.28;
    letter-spacing: -0.02em;
    color: var(--realblack);
    margin: 0 0 16px;
    max-width: 22ch;
}
.medic-description.about-medic__body,
.about-medic__body {
    font-size: 0.95rem;
    color: #4b5563;
    line-height: 1.75;
    text-align: start;
    max-width: 38rem;
}
.medic-description.about-medic__body p,
.about-medic__body p {
    margin: 0 0 1em;
    text-align: start !important;
}
.medic-description.about-medic__body p:last-child,
.about-medic__body p:last-child {
    margin-bottom: 0;
}
.welcome-actions {
    margin-top: 22px;
}
.about-medic__cta.btn-primary {
    padding: 12px 24px;
    font-weight: 600;
    letter-spacing: 0.02em;
    box-shadow: 0 6px 20px rgba(138, 29, 3, 0.25);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.about-medic__cta.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(138, 29, 3, 0.32);
}
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

/* Types of spaces */
.home-space-types { margin: 10px 0 40px; padding: 26px 0 8px; background: #ffffff; }
.space-types-grid { max-width: 1200px; margin: 0 auto; padding: 0 22px; display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; }
.space-type-card { background: #ffffff; border-radius: 14px; padding: 18px 18px 18px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.06); transition: transform 0.2s ease, box-shadow 0.2s ease; display: flex; flex-direction: column; min-height: 220px; }
.space-type-card:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(0,0,0,0.10); }
.space-type-card__top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 10px; }
.space-type-card__title { font-size: 1rem; font-weight: 700; margin: 0; color: var(--realblack); line-height: 1.3; }
.space-type-card__price { font-size: 0.85rem; color: var(--primary); font-weight: 800; background: rgba(138,29,3,0.08); border: 1px solid rgba(138,29,3,0.14); padding: 6px 10px; border-radius: 999px; white-space: nowrap; }
.space-type-card__desc { margin: 0; color: #555; font-size: 0.9rem; line-height: 1.7; flex: 1; }
.space-type-card__actions { margin-top: 14px; }
.space-type-card__button { width: 100%; justify-content: center; }

@media (max-width: 1024px) {
    .space-types-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 640px) {
    .home-space-types { padding: 18px 0 10px; }
    .space-types-grid { grid-template-columns: minmax(0, 1fr); padding: 0 16px; }
}

/* CTA background using home background image */
.home-background-cta { position: relative; border-radius: 18px; overflow: hidden; min-height: 260px; margin: 12px 0 32px; }
.home-background-cta__bg { position: absolute; inset: 0; background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; }
.home-background-cta__overlay { position: absolute; inset: 0; background: linear-gradient(to right, rgba(0,0,0,0.65), rgba(0,0,0,0.05)); }
.home-background-cta__content { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; padding: 34px 32px; }
.home-background-cta__inner { width: min(1040px, 100%); color: #ffffff; }
.home-background-cta__caption {
    font-size: 0.98rem;
    line-height: 1.8;
    margin: 0 auto 16px;
    max-width: 760px;
    text-align: center;
    text-shadow: 0 2px 12px rgba(0,0,0,0.38);
}
.home-background-cta__quote {
    margin: 0 auto 18px;
    max-width: 980px;
    text-align: center;
    color: #ffffff;
    font-size: clamp(1.55rem, 3vw, 2.35rem);
    font-weight: 800;
    line-height: 1.28;
    letter-spacing: -0.02em;
    text-shadow: 0 4px 18px rgba(0, 0, 0, 0.62);
}
.home-background-cta__details {
    display: grid;
    gap: 16px;
}
.home-background-cta__panel {
    border-radius: 18px;
    padding: 8px 4px;
    color: #ffffff;
}
.home-background-cta__feature-tags {
    display: grid;
    grid-template-columns: repeat(2, minmax(280px, 420px));
    justify-content: center;
    gap: 14px 26px;
    max-width: 940px;
    margin: 0 auto;
}
.home-background-cta__tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 1.18rem;
    font-weight: 700;
    line-height: 1.25;
    letter-spacing: -0.01em;
    color: #ffffff;
    border-radius: 14px;
    padding: 11px 14px;
    min-height: 58px;
    text-shadow: 0 3px 12px rgba(0, 0, 0, 0.72);
    background: linear-gradient(180deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.08));
    border: 1px solid rgba(255, 255, 255, 0.34);
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.22);
    backdrop-filter: blur(2px);
}
.home-background-cta__tag::before {
    content: "";
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #ffb199;
    box-shadow: 0 0 0 6px rgba(255, 177, 153, 0.24);
    flex-shrink: 0;
}
.home-background-cta__audience-title {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 12px;
    color: #ffffff;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.65);
}
.home-background-cta__audience-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #ffd3c4;
    background: rgba(255, 255, 255, 0.16);
}
.home-background-cta__audience-chips {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 10px;
}
.home-background-cta__chip {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-size: 0.9rem;
    font-weight: 600;
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.38);
    border-radius: 12px;
    min-height: 48px;
    padding: 8px 10px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(2px);
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.62);
}
@media (max-width: 768px) {
    .home-background-cta__bg { background-attachment: scroll; }
    .home-background-cta__content { padding: 22px 16px; }
    .home-background-cta__panel { padding: 10px 0; border-radius: 14px; }
    .home-background-cta__quote {
        font-size: clamp(1.15rem, 5.7vw, 1.6rem);
        margin-bottom: 14px;
    }
    .home-background-cta__feature-tags {
        grid-template-columns: minmax(0, 1fr);
        max-width: 100%;
        gap: 10px;
    }
    .home-background-cta__tag {
        font-size: 1rem;
        min-height: 52px;
        padding: 10px 12px;
    }
    .home-background-cta__audience-chips { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

/* CTA block below background image: contacts left, office enquiry form right */
.home-cta-contact-enquiry {
    margin: 0 0 40px;
}
.home-cta-contact-enquiry__inner {
    position: relative;
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.2fr);
    gap: 28px;
    align-items: stretch;
    padding: 26px 24px 28px;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
}
.home-cta-contact-enquiry__inner::before {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    height: 4px;
    border-radius: 18px 18px 0 0;
    background: linear-gradient(90deg, var(--primary), #5c1304);
}
.home-cta-contact-enquiry__panel {
    height: 100%;
    display: flex;
    flex-direction: column;
}
.home-cta-contact-enquiry__kicker {
    display: inline-block;
    font-size: 0.72rem;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--primary);
    font-weight: 600;
    margin: 0 0 6px;
}
.home-cta-contact-enquiry__title {
    font-size: 1.45rem;
    font-weight: 700;
    margin: 0 0 8px;
    letter-spacing: -0.02em;
    color: var(--realblack);
}
.home-cta-contact-enquiry__subtitle {
    font-size: 0.95rem;
    line-height: 1.55;
    color: #64748b;
    margin: 0 0 18px;
    max-width: 28rem;
}
.home-cta-contact-enquiry__contacts {
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
}
.home-cta-contact-enquiry__card {
    display: flex;
    gap: 14px;
    align-items: flex-start;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #e8ecf0;
    background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.home-cta-contact-enquiry__card:hover {
    border-color: rgba(0, 0, 0, 0.1);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.06);
}
.home-cta-contact-enquiry__card-icon {
    flex-shrink: 0;
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary);
}
.home-cta-contact-enquiry__card-body {
    min-width: 0;
}
.home-cta-contact-enquiry__item-label {
    font-size: 0.68rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #94a3b8;
    margin-bottom: 4px;
}
.home-cta-contact-enquiry__item-value {
    font-size: 0.95rem;
    line-height: 1.5;
    color: var(--realblack);
}
.home-cta-contact-enquiry__address p {
    margin: 0 0 0.35rem;
}
.home-cta-contact-enquiry__address p:last-child {
    margin-bottom: 0;
}
.home-cta-contact-enquiry__item-value a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}
.home-cta-contact-enquiry__item-value a:hover {
    text-decoration: underline;
}
.home-cta-contact-enquiry__sep {
    color: #cbd5e1;
    margin: 0 0.2rem;
}
.home-cta-contact-enquiry__col--form {
    border-left: 1px solid #eef0f3;
    padding-left: 24px;
}

@media (max-width: 900px) {
    .home-cta-contact-enquiry__inner {
        grid-template-columns: 1fr;
    }
    .home-cta-contact-enquiry__col--form {
        border-left: none;
        padding-left: 0;
        border-top: 1px solid #eef0f3;
        padding-top: 22px;
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
