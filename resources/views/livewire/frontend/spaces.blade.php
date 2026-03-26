<div>
    @php
        $locatorTitle = ($page && $page->hero_title) ? $page->hero_title : 'Space to Let';
        $locatorPreferHeaderTitle = ! ($page && $page->hero_title);
    @endphp
    <x-page-locator
        :title="$locatorTitle"
        :header="$header ?? null"
        :uppercase-title="false"
        :use-header-title="$locatorPreferHeaderTitle"
    />
    <div class="content">
        <section class="spaces-page">
            {{-- CMS content (value proposition + details) --}}
            @if(isset($page) && $page)
                <div class="space-landing">
                    @php
                        $landingBgImage = null;
                        if (!empty($page->gallery_images) && isset($page->gallery_images[0])) {
                            $landingBgImage = asset($page->gallery_images[0]);
                        } elseif (!empty($settings?->home_background_image_path)) {
                            $landingBgImage = asset($settings->home_background_image_path);
                        }
                    @endphp
                    @php
                        $effectiveMapUrl = $settings->map_embed_url ?? $page->google_map_embed_url;
                    @endphp
                    <div class="space-landing__hero">
                        <div class="space-landing__hero-panel">
                            {{-- @if($page->hero_subtitle)
                                <p class="space-landing__subtitle">{{ $page->hero_subtitle }}</p>
                            @endif --}}

                            @if(!empty($page->hero_bullets))
                                <div class="space-landing__bullets">
                                    @foreach($page->hero_bullets as $b)
                                        <div class="space-landing__bullet">{{ $b }}</div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="space-landing__cta-row">
                                <a href="#space-enquiry" class="btn-primary">Book a tour</a>
                                <a href="#spaces-listings" class="link-underlined">See available spaces</a>
                            </div>
                        </div>
                    </div>

                    @if(!empty($page->ideal_for) || $page->pricing_html || (isset($testimonials) && $testimonials->count()))
                        <div class="space-landing__extras">
                            @if(!empty($page->ideal_for))
                                <div class="space-landing__extra-card space-landing__extra-card--ideal">
                                    <div class="space-landing__extra-card__head">
                                        <span class="space-landing__extra-card__icon" aria-hidden="true">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        </span>
                                        <h3 class="space-landing__section-title space-landing__extra-card__title">Who it’s ideal for</h3>
                                    </div>
                                    <div class="ideal-for">
                                        @foreach($page->ideal_for as $who)
                                            <div class="ideal-for__item">{{ $who }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- @if($page->pricing_html)
                                <div class="space-landing__extra-card">
                                    <h3 class="space-landing__section-title">Pricing</h3>
                                    <div class="space-landing__rich">{!! $page->pricing_html !!}</div>
                                </div>
                            @endif

                            @if(isset($testimonials) && $testimonials->count())
                                <div class="space-landing__extra-card">
                                    <h3 class="space-landing__section-title">Testimonials</h3>
                                    <div class="testimonials">
                                        @foreach($testimonials as $t)
                                            <div class="testimonial">
                                                <div class="testimonial__quote">“{{ $t->quote }}”</div>
                                                <div class="testimonial__by">
                                                    {{ $t->name ?? '' }}
                                                    @if(!empty($t->role))<span class="testimonial__role"> — {{ $t->role }}</span>@endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif --}}
                        </div>
                    @endif

                    <section id="spaces-listings" class="space-landing__feature-band"
                             @if($landingBgImage)
                                 style="background-image: url('{{ $landingBgImage }}');"
                             @endif>
                        <div class="space-landing__feature-overlay"></div>
                        <div class="space-landing__feature-inner">
                            <div class="space-landing__grid">
                                <div class="space-landing__col space-landing__col--types">
                                    @if(isset($spaceTypes) && $spaceTypes->count())
                                        <div class="space-landing__section-heading">
                                            <span class="space-landing__section-kicker">Your options</span>
                                            <h3 class="space-landing__section-title">Types of spaces available</h3>
                                        </div>
                                        <div class="space-types">
                                            @foreach($spaceTypes as $type)
                                                @php
                                                    $priceDisplay = $type->starting_price;
                                                    if ($priceDisplay !== null && $priceDisplay !== '') {
                                                        $hasLetters = (bool) preg_match('/[a-zA-Z]/u', $priceDisplay);
                                                        if (! $hasLetters) {
                                                            $digits = preg_replace('/\D/', '', $priceDisplay);
                                                            if ($digits !== '' && (int) $digits > 0) {
                                                                $priceDisplay = number_format((int) $digits, 0) . ' RWF';
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <div class="space-type">
                                                    <div class="space-type__head">
                                                        <h4 class="space-type__title">{{ $type->title }}</h4>
                                                    </div>
                                                    @if(!empty($type->starting_price))
                                                        <div class="space-type__price-bar">
                                                            <span class="space-type__price-label">From</span>
                                                            <span class="space-type__price-value">{{ $priceDisplay }}</span>
                                                        </div>
                                                    @endif
                                                    @if($type->description)
                                                        <div class="space-type__desc space-landing__rich">{!! $type->description !!}</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="space-landing__col space-landing__col--amenities">
                                    @if(!empty($page->amenities))
                                        <div class="space-landing__section-heading space-landing__section-heading--center">
                                            <span class="space-landing__section-kicker">Building</span>
                                            <h3 class="space-landing__section-title">Amenities &amp; features</h3>
                                        </div>
                                        <div class="amenities">
                                            @foreach($page->amenities as $a)
                                                <div class="amenities__item">
                                                    <span class="amenities__icon" aria-hidden="true">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 6L9 17l-5-5"/></svg>
                                                    </span>
                                                    <span class="amenities__text">{{ $a }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>

                    @if(!empty($page->gallery_images))
                        <div class="space-landing__gallery">
                            <h3 class="space-landing__section-title">Visuals</h3>
                            <div class="space-gallery">
                                @foreach($page->gallery_images as $img)
                                    <div class="space-gallery__item">
                                        <img src="{{ asset($img) }}" alt="Office space photo" loading="lazy">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="space-landing__bottom">
                        <div id="space-enquiry" class="space-landing__enquiry">
                            <livewire:frontend.space-to-let-enquiry />
                        </div>
                        <x-google-map-embed
                            class="space-landing__map-panel"
                            :embed="$effectiveMapUrl"
                            :min-height="380"
                            title="Centenary House location map"
                            empty-message="Add a Google Maps embed URL in Admin to display location here."
                        />
                    </div>


                </div>
            @else
                <div class="spaces-header">
                    <h2 class="section-heading">Available Spaces to Let</h2>
                    <p class="section-sub">
                        Browse the currently available office and commercial spaces at Centenary House.
                    </p>
                </div>
            @endif

        </section>
    </div>

    <style>
    .spaces-page {
        padding: 30px 0 40px;
    }

    .space-landing__hero {
        width: 100%;
        margin: 0 0 8px;
        padding: 28px 18px 8px;
        text-align: center;
        background: linear-gradient(180deg, rgba(138, 29, 3, 0.04) 0%, rgba(255, 255, 255, 0) 55%);
    }
    .space-landing__hero-panel {
        max-width: 920px;
        margin: 0 auto;
        padding: 28px 26px 30px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
    }
    .space-landing__hero-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark, #6b1502));
        opacity: 0.9;
    }
    .space-landing__subtitle {
        margin: 0 auto 20px;
        color: #333;
        max-width: 720px;
        line-height: 1.75;
        font-size: 1.05rem;
        font-weight: 500;
        letter-spacing: 0.01em;
    }
    .space-landing__bullets {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin: 6px 0 22px;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
        touch-action: pan-x;
        padding-bottom: 4px;
        scrollbar-width: thin;
    }
    .space-landing__bullets::-webkit-scrollbar {
        height: 6px;
    }
    .space-landing__bullets::-webkit-scrollbar-thumb {
        background: rgba(138, 29, 3, 0.25);
        border-radius: 999px;
    }
    .space-landing__bullet {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px 10px 12px;
        border-radius: 999px;
        background: linear-gradient(180deg, #fff 0%, #fafafa 100%);
        color: #333;
        font-size: 0.88rem;
        font-weight: 600;
        border: 1px solid rgba(138, 29, 3, 0.14);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .space-landing__bullet:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(138, 29, 3, 0.12);
        border-color: rgba(138, 29, 3, 0.28);
    }
    .space-landing__bullet::before {
        content: '';
        display: inline-block;
        width: 22px;
        height: 22px;
        flex-shrink: 0;
        border-radius: 50%;
        background-color: var(--primary);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2.5'%3E%3Cpath d='M20 6L9 17l-5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 14px 14px;
        box-shadow: 0 2px 6px rgba(138, 29, 3, 0.35);
    }
    .space-landing__cta-row {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        margin: 4px 0 0;
        flex-wrap: wrap;
    }
    .space-landing__hero .link-underlined {
        font-size: 0.9rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }
    .space-landing__hero .link-underlined:hover {
        text-decoration: underline;
    }

    .space-landing__grid {
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        column-gap: 56px;
        row-gap: 28px;
        align-items: start;
    }
    .space-landing__feature-band {
        position: relative;
        width: 100vw;
        margin-left: 50%;
        transform: translateX(-50%);
        margin-top: 18px;
        margin-bottom: 22px;
        min-height: 100vh;
        padding: 56px 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed; /* parallax */
        border-radius: 0;
        overflow: hidden;
    }
    .space-landing__feature-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0,0,0,0.58), rgba(0,0,0,0.30));
    }
    .space-landing__feature-inner {
        position: relative;
        z-index: 1;
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 22px;
        min-height: calc(100vh - 112px);
        display: flex;
        align-items: center;
    }
    .space-landing__col {
        background: transparent;
        border-radius: 0;
        padding: 8px 4px;
        box-shadow: none;
        border: 0;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .space-landing__col--amenities {
        text-align: center;
        align-items: center;
    }
    .space-landing__col--amenities .space-landing__section-heading--center {
        text-align: center;
    }
    .space-landing__section-heading {
        margin-bottom: 18px;
    }
    .space-landing__section-heading--center .space-landing__section-kicker,
    .space-landing__section-heading--center .space-landing__section-title {
        margin-left: auto;
        margin-right: auto;
    }
    .space-landing__section-kicker {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 6px;
    }
    .space-landing__feature-inner .space-landing__section-kicker {
        color: #ffb4a6;
        text-shadow: 0 1px 8px rgba(0,0,0,0.4);
    }
    .space-landing__section-title {
        margin: 0 0 10px;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--realblack);
    }
    .space-landing__section-title--mt { margin-top: 16px; }
    .space-landing__rich { color: #444; line-height: 1.8; font-size: 0.92rem; }
    .space-landing__rich p { margin: 0 0 10px; }

    .space-types { display: flex; flex-direction: column; gap: 14px; }
    .space-type {
        padding: 16px 16px 18px;
        border-radius: 14px;
        background: #fafafa;
        border: 1px solid rgba(0,0,0,0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .space-type:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.08);
    }
    .space-type__head { margin-bottom: 8px; }
    .space-type__title {
        margin: 0;
        font-size: 1.02rem;
        font-weight: 700;
        color: var(--realblack);
        line-height: 1.35;
        letter-spacing: 0.01em;
    }
    .space-type__price-bar {
        display: inline-flex;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 6px 10px;
        margin: 0 0 12px;
        padding: 8px 12px;
        border-radius: 10px;
        background: rgba(138, 29, 3, 0.08);
        border: 1px solid rgba(138, 29, 3, 0.15);
    }
    .space-type__price-label {
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--primary);
    }
    .space-type__price-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--realblack);
    }
    .space-type__desc { margin: 0; color: #555; font-size: 0.9rem; line-height: 1.65; }
    .space-type__desc ul { margin: 0.4em 0 0; padding-left: 1.1em; }

    .amenities {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }
    .amenities__item {
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: left;
        padding: 12px 14px;
        border-radius: 12px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        backdrop-filter: blur(8px);
        transition: background 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
    }
    .amenities__item:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.22);
        transform: translateX(4px);
    }
    .amenities__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        border-radius: 50%;
        background: rgba(138, 29, 3, 0.85);
        color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    .amenities__icon svg { display: block; }
    .amenities__text {
        font-size: 0.93rem;
        font-weight: 600;
        color: #333;
        line-height: 1.45;
    }

    .space-landing__feature-inner .space-landing__section-title {
        color: #ffffff;
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-shadow: 0 2px 14px rgba(0,0,0,0.45);
        margin-bottom: 0;
        padding-bottom: 10px;
        border-bottom: 2px solid rgba(255,255,255,0.22);
    }
    .space-landing__feature-inner .space-landing__section-heading {
        margin-bottom: 22px;
    }
    .space-landing__feature-inner .space-landing__rich {
        color: rgba(255,255,255,0.92);
    }
    .space-landing__feature-inner .space-type {
        background: rgba(255,255,255,0.09);
        border: 1px solid rgba(255,255,255,0.2);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    }
    .space-landing__feature-inner .space-type:hover {
        border-color: rgba(255,255,255,0.32);
        box-shadow: 0 14px 40px rgba(0,0,0,0.28);
    }
    .space-landing__feature-inner .space-type__title {
        color: #fff;
        font-size: 1.05rem;
    }
    .space-landing__feature-inner .space-type__desc {
        color: rgba(255,255,255,0.88);
        font-size: 0.9rem;
    }
    .space-landing__feature-inner .space-type__desc li::marker { color: rgba(255,200,190,0.9); }
    .space-landing__feature-inner .space-type__price-bar {
        background: rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.18);
    }
    .space-landing__feature-inner .space-type__price-label {
        color: #ffc9bd;
    }
    .space-landing__feature-inner .space-type__price-value {
        color: #fff;
        font-weight: 700;
    }
    .space-landing__feature-inner .amenities__item {
        background: rgba(255,255,255,0.07);
        border-color: rgba(255,255,255,0.14);
    }
    .space-landing__feature-inner .amenities__item:hover {
        background: rgba(255,255,255,0.11);
        border-color: rgba(255,255,255,0.28);
    }
    .space-landing__feature-inner .amenities__text {
        color: rgba(255,255,255,0.96);
        font-weight: 600;
    }
    .space-landing__feature-inner .amenities__icon {
        background: linear-gradient(145deg, var(--primary), #5c1304);
        border: 1px solid rgba(255,255,255,0.25);
    }

    .space-landing__gallery { margin: 12px 0 18px; }
    .space-gallery { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
    .space-gallery__item { border-radius: 14px; overflow: hidden; box-shadow: 0 10px 28px rgba(0,0,0,0.08); }
    .space-gallery__item img { width: 100%; height: 160px; object-fit: cover; display: block; }

    .space-landing__bottom {
        margin: 18px 0 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        align-items: stretch;
    }
    .space-landing__enquiry {
        min-height: 380px;
        display: flex;
        align-items: stretch;
    }
    .space-landing__enquiry .space-enquiry {
        width: 100%;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .space-landing__extras {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin: 22px auto 32px;
        max-width: 960px;
        padding: 0 18px;
        justify-items: stretch;
    }
    .space-landing__extra-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 22px 24px;
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.07);
        border: 1px solid rgba(0, 0, 0, 0.06);
        transition: box-shadow 0.25s ease, transform 0.25s ease;
    }
    .space-landing__extra-card:hover {
        box-shadow: 0 16px 44px rgba(0, 0, 0, 0.1);
    }
    .space-landing__extra-card--ideal {
        border-left: 4px solid var(--primary);
        padding-left: 24px;
    }
    .space-landing__extra-card__head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        text-align: left;
    }
    .space-landing__extra-card__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(138, 29, 3, 0.09);
        color: var(--primary);
        flex-shrink: 0;
    }
    .space-landing__extra-card__title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--realblack);
        line-height: 1.3;
    }
    .ideal-for {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 12px;
    }
    .ideal-for__item {
        padding: 12px 14px;
        border-radius: 12px;
        text-align: center;
        font-size: 0.88rem;
        font-weight: 600;
        color: #333;
        background: linear-gradient(180deg, #fafafa 0%, #f3f3f4 100%);
        border: 1px solid rgba(138, 29, 3, 0.12);
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
    }
    .ideal-for__item:hover {
        background: rgba(138, 29, 3, 0.06);
        border-color: rgba(138, 29, 3, 0.25);
        color: var(--primary);
    }
    .testimonials { display: flex; flex-direction: column; gap: 12px; }
    .testimonial { padding: 12px 12px; border-radius: 12px; background: #fafafa; border: 1px solid rgba(0,0,0,0.06); }
    .testimonial__quote { color: #444; font-size: 0.92rem; line-height: 1.7; }
    .testimonial__by { margin-top: 8px; color: #111; font-weight: 700; font-size: 0.9rem; }
    .testimonial__role { color: #666; font-weight: 600; }

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
        .space-landing__grid { grid-template-columns: 1fr; column-gap: 18px; }
        .space-gallery { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .space-landing__bottom { margin: 18px 0 24px; grid-template-columns: 1fr; }
        .space-landing__extras { grid-template-columns: 1fr; }
    }

    @media (max-width: 900px) {
        .space-landing__bullets {
            justify-content: flex-start;
        }
    }

    @media (max-width: 600px) {
        .spaces-grid {
            grid-template-columns: 1fr;
        }

        .spaces-page {
            padding: 24px 0 32px;
        }
        .space-landing__hero {
            padding: 18px 14px 4px;
        }
        .space-landing__hero-panel {
            padding: 22px 18px 24px;
        }
        .space-landing__subtitle {
            font-size: 0.98rem;
        }
        .space-landing__bullet {
            font-size: 0.82rem;
            padding: 8px 12px 8px 10px;
        }
        .ideal-for {
            grid-template-columns: 1fr 1fr;
        }
        .space-gallery__item img { height: 140px; }
        .space-landing__feature-band {
            background-attachment: scroll;
            padding: 18px 0;
            min-height: auto;
        }
        .space-landing__feature-inner {
            padding: 0 16px;
            min-height: auto;
            display: block;
        }
    }
    </style>
</div>

