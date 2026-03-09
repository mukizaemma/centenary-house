<div>
    <x-page-locator title="About us" :header="$header ?? null" />
    <div class="content">
        <div class="about-page">
            @if($settings)
                {{-- Intro: about text --}}
                <section class="about-intro">
                    <span class="about-label">ABOUT US</span>
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
                </section>

                {{-- Mission / Vision --}}
                @if($settings->mission || $settings->vision)
                    <section class="about-mission">
                        <div class="mission-grid">
                            @if($settings->mission)
                                <article class="mission-card">
                                    <h3 class="mission-card__title">Our mission</h3>
                                    <div class="mission-card__body">
                                        {!! $settings->mission !!}
                                    </div>
                                </article>
                            @endif
                            @if($settings->vision)
                                <article class="mission-card">
                                    <h3 class="mission-card__title">Our vision</h3>
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
                            <span class="about-label">OUR TEAM</span>
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

    <style>
    .about-page {
        margin: 40px 0 32px;
    }

    .about-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .about-main-heading {
        font-size: 2rem;
        font-weight: 600;
        margin: 12px 0 16px;
        line-height: 1.3;
    }

    @media (max-width: 768px) {
        .about-main-heading {
            font-size: 1.6rem;
        }
    }

    .about-intro {
        max-width: 800px;
        margin: 0 auto 36px;
        text-align: center;
    }

    .about-intro__text {
        font-size: 0.96rem;
        color: #555;
        line-height: 1.8;
    }

    .about-paragraph + .about-paragraph {
        margin-top: 12px;
    }

    .about-mission {
        margin: 10px 0 40px;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
    }

    .mission-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px 22px;
        box-shadow: 0 4px 22px rgba(0, 0, 0, 0.06);
    }

    .mission-card__title {
        font-size: 1.05rem;
        font-weight: 600;
        margin: 0 0 10px;
        color: var(--realblack);
    }

    .mission-card__body {
        font-size: 0.92rem;
        color: #555;
        line-height: 1.7;
    }

    .mission-card__body p {
        margin-bottom: 0.8em;
    }

    /* Team section */
    .team-section {
        margin: 10px 0 32px;
    }

    .team-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .team-heading {
        font-size: 1.6rem;
        font-weight: 600;
        margin: 12px 0 8px;
        color: var(--realblack);
    }

    .team-subtitle {
        font-size: 0.95rem;
        color: #666;
        margin: 0;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        align-items: stretch;
    }

    .team-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px 24px 28px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .team-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .team-photo-wrap {
        width: 100%;
        height: 220px;
        border-radius: 12px;
        overflow: hidden;
        background: #f5f5f5;
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
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 4px;
        color: var(--realblack);
    }

    .team-position {
        font-size: 0.9rem;
        color: var(--primary);
        font-weight: 500;
        margin: 0 0 8px;
    }

    .team-contact {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 8px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 4px;
    }

    .team-contact-item {
        color: inherit;
        text-decoration: none;
    }

    .team-contact-item:hover {
        text-decoration: underline;
    }

    .team-contact-separator {
        color: #ccc;
    }

    .team-bio {
        font-size: 0.9rem;
        color: #555;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 600px) {
        .team-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</div>
