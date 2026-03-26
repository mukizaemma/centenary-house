<div>
    <x-page-locator title="About us" :header="$header ?? null" />
    <div class="content">
        <div class="about-page">
            <div class="about-page__inner">
            @if($settings)
                {{-- Intro: about text --}}
                <section class="about-intro">
                    <div class="about-intro__surface">
                        <span class="about-label">About us</span>
                        <h2 class="about-main-heading">
                            {{ $settings->about_heading ?? 'About ' . ($settings->company_name ?? 'Centenary House') }}
                        </h2>
                        <div class="about-intro__text">
                            @if($settings->about_description)
                                <div class="about-paragraph">
                                    {!! $settings->about_description !!}
                                </div>
                            @endif
                            @if($settings->about_history)
                                <div class="about-paragraph">
                                    {!! $settings->about_history !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- Mission / Vision --}}
                @if($settings->mission || $settings->vision)
                    <section class="about-mission">
                        <header class="about-mission__intro">
                            <span class="about-label">Mission &amp; vision</span>
                            <h2 class="about-mission__heading">What drives us</h2>
                            <p class="about-mission__lead">How we work and where we are headed as an organization.</p>
                        </header>
                        <div class="mission-grid">
                            @if($settings->mission)
                                <article class="mission-card">
                                    <div class="mission-card__head">
                                        <span class="mission-card__icon" aria-hidden="true">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                        </span>
                                        <h3 class="mission-card__title">Our mission</h3>
                                    </div>
                                    <div class="mission-card__body">
                                        {!! $settings->mission !!}
                                    </div>
                                </article>
                            @endif
                            @if($settings->vision)
                                <article class="mission-card">
                                    <div class="mission-card__head">
                                        <span class="mission-card__icon" aria-hidden="true">
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </span>
                                        <h3 class="mission-card__title">Our vision</h3>
                                    </div>
                                    <div class="mission-card__body">
                                        {!! $settings->vision !!}
                                    </div>
                                </article>
                            @endif
                        </div>
                    </section>
                @endif

                {{-- Our Team directly under mission --}}
                @if(!empty($teamMembers) && $teamMembers->count())
                    <section class="team-section">
                        <div class="team-header">
                            <span class="about-label">Our team</span>
                            <h3 class="team-heading">Our Team</h3>
                            <p class="team-subtitle">
                                People serving at {{ $settings->company_name ?? 'our organization' }}
                            </p>
                        </div>
                        <div class="team-grid">
                            @foreach($teamMembers as $member)
                                <article class="team-card">
                                    @if($member->photo_path)
                                        <div class="team-photo-wrap">
                                            <img src="{{ asset($member->photo_path) }}" alt="{{ $member->full_name }}" class="team-photo-full">
                                        </div>
                                    @endif
                                    <div class="team-body">
                                        @if($member->full_name)
                                            <h4 class="team-name">{{ $member->full_name }}</h4>
                                        @endif
                                        @if($member->position)
                                            <p class="team-position">{{ $member->position }}</p>
                                        @endif
                                        @if($member->email || $member->phone)
                                            <div class="team-contact">
                                                @if($member->email)
                                                    <a href="mailto:{{ $member->email }}" class="team-contact-item">{{ $member->email }}</a>
                                                @endif
                                                @if($member->phone)
                                                    <span class="team-contact-separator">&middot;</span>
                                                    <a href="tel:{{ $member->phone }}" class="team-contact-item">{{ $member->phone }}</a>
                                                @endif
                                            </div>
                                        @endif
                                        @if($member->biography)
                                            @php
                                                $bioText = strip_tags($member->biography);
                                                $bioShort = \Illuminate\Support\Str::limit($bioText, 120, '…');
                                            @endphp
                                            <p class="team-bio">{{ $bioShort }}</p>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endif
            </div>
        </div>
    </div>

    <style>
    .about-page {
        margin: 0;
        padding: 28px 0 52px;
        background: linear-gradient(180deg, #fafbfc 0%, #ffffff 32%, #ffffff 100%);
    }

    .about-page__inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 4px;
    }

    .about-label {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.16em;
    }

    .about-intro {
        max-width: 920px;
        margin: 0 auto 40px;
        text-align: center;
    }

    .about-intro__surface {
        position: relative;
        padding: 32px 36px 36px;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.07);
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.02),
            0 18px 44px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        text-align: center;
    }

    .about-intro__surface::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #5c1304);
        border-radius: 18px 18px 0 0;
    }

    .about-main-heading {
        font-size: clamp(1.55rem, 3.2vw, 2.05rem);
        font-weight: 700;
        margin: 10px 0 20px;
        line-height: 1.25;
        letter-spacing: -0.02em;
        color: var(--realblack);
        position: relative;
        padding-bottom: 16px;
    }

    .about-main-heading::after {
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

    .about-intro__text {
        font-size: 0.96rem;
        color: #4b5563;
        line-height: 1.75;
        text-align: start;
        max-width: 42rem;
        margin: 0 auto;
    }

    .about-intro__text p {
        margin: 0 0 1em;
        text-align: start !important;
    }

    .about-intro__text p:last-child {
        margin-bottom: 0;
    }

    .about-paragraph + .about-paragraph {
        margin-top: 1.25rem;
    }

    .about-mission {
        margin: 12px 0 32px;
    }

    .about-mission__intro {
        text-align: center;
        max-width: 640px;
        margin: 0 auto 28px;
        padding: 0 8px;
    }

    .about-mission__intro .about-label {
        margin-bottom: 10px;
    }

    .about-mission__heading {
        margin: 0 0 8px;
        font-size: clamp(1.35rem, 2.5vw, 1.65rem);
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--realblack);
        line-height: 1.2;
        position: relative;
        padding-bottom: 14px;
    }

    .about-mission__heading::after {
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

    .about-mission__lead {
        margin: 14px 0 0;
        font-size: 0.95rem;
        color: #64748b;
        line-height: 1.6;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 22px;
    }

    .mission-card {
        position: relative;
        background: #ffffff;
        border-radius: 16px;
        padding: 22px 24px 24px;
        border: 1px solid rgba(0, 0, 0, 0.07);
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.02),
            0 12px 36px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .mission-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), rgba(92, 19, 4, 0.65));
        opacity: 0.95;
    }

    .mission-card:hover {
        border-color: rgba(138, 29, 3, 0.2);
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.03),
            0 16px 44px rgba(0, 0, 0, 0.1);
    }

    .mission-card__head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .mission-card__icon {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
    }

    .mission-card__icon svg {
        display: block;
    }

    .mission-card__title {
        font-size: 1.08rem;
        font-weight: 700;
        margin: 0;
        color: var(--realblack);
        letter-spacing: -0.01em;
    }

    .mission-card__body {
        font-size: 0.93rem;
        color: #4b5563;
        line-height: 1.7;
        text-align: start;
    }

    .mission-card__body p {
        margin-bottom: 0.85em;
    }

    .mission-card__body p:last-child {
        margin-bottom: 0;
    }

    /* Team section */
    .team-section {
        margin: 36px 0 40px;
        padding: 40px 28px 36px;
        border-radius: 18px;
        background: linear-gradient(180deg, #f7f5f4 0%, #fafafa 45%, #ffffff 100%);
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }

    .team-header {
        text-align: center;
        margin-bottom: 28px;
        max-width: 36rem;
        margin-left: auto;
        margin-right: auto;
    }

    .team-header .about-label {
        margin-bottom: 10px;
    }

    .team-heading {
        font-size: clamp(1.35rem, 2.5vw, 1.65rem);
        font-weight: 700;
        margin: 0 0 8px;
        color: var(--realblack);
        letter-spacing: -0.02em;
        position: relative;
        padding-bottom: 14px;
    }

    .team-heading::after {
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

    .team-subtitle {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
        align-items: stretch;
    }

    .team-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 20px 24px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .team-card:hover {
        transform: translateY(-4px);
        border-color: rgba(138, 29, 3, 0.15);
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.1);
    }

    .team-photo-wrap {
        width: 100%;
        height: 210px;
        border-radius: 12px;
        overflow: hidden;
        background: #ececec;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .team-photo-full {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .team-body {
        flex: 1;
        min-width: 0;
    }

    .team-name {
        font-size: 1.05rem;
        font-weight: 700;
        margin: 0 0 4px;
        color: var(--realblack);
        letter-spacing: -0.01em;
    }

    .team-position {
        font-size: 0.88rem;
        color: var(--primary);
        font-weight: 600;
        margin: 0 0 8px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .team-contact {
        font-size: 0.84rem;
        color: #64748b;
        margin-bottom: 8px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 4px;
    }

    .team-contact-item {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .team-contact-item:hover {
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .team-contact-separator {
        color: #cbd5e1;
    }

    .team-bio {
        font-size: 0.88rem;
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 900px) {
        .team-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .about-intro__surface {
            padding: 26px 22px 28px;
        }
    }

    @media (max-width: 600px) {
        .about-page__inner {
            padding: 0;
        }
        .team-section {
            padding: 28px 16px 28px;
            border-radius: 14px;
        }
        .team-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</div>
