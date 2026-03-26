<div>
    <x-page-locator title="Trusted Partners" />
    <div class="content">
        <section class="partners-page">
            <div class="partners-page__intro">
                <h2 class="section-heading">Trusted Partners</h2>
                <p class="section-sub">
                    Explore the organisations we work with.
                </p>
            </div>

            @if($partners->isEmpty())
                <p class="partners-empty">No partners are currently published.</p>
            @else
                <div class="partners-grid">
                    @foreach($partners as $partner)
                        @php
                            $hasWebsite = !empty($partner->website_url);
                            $href = $hasWebsite ? $partner->website_url : route('partners.show', $partner);
                        @endphp
                        <a
                            class="partner-card"
                            href="{{ $href }}"
                            @if($hasWebsite) target="_blank" rel="noopener" @else wire:navigate @endif
                        >
                            <div class="partner-card__logo">
                                @if($partner->logo_path)
                                    <img src="{{ asset($partner->logo_path) }}" alt="{{ $partner->name }}" loading="lazy">
                                @else
                                    <div class="partner-card__logo-placeholder">{{ $partner->name }}</div>
                                @endif
                            </div>
                            <div class="partner-card__body">
                                <h3 class="partner-card__title">{{ $partner->name }}</h3>
                                @if($partner->website_url)
                                    <div class="partner-card__meta">{{ $partner->website_url }}</div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <style>
        .partners-page { padding: 30px 0 44px; }
        .partners-page__intro { max-width: 720px; margin: 0 auto 26px; text-align: center; }

        .partners-empty { text-align: center; color: #666; }

        .partners-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .partner-card {
            background: #ffffff;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 14px;
            overflow: hidden;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
            display: flex;
            flex-direction: column;
            min-height: 180px;
        }

        .partner-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(0,0,0,0.08);
            border-color: rgba(0,0,0,0.12);
        }

        .partner-card__logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px 16px;
            background: #fafafa;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            min-height: 96px;
        }

        .partner-card__logo img {
            max-width: 100%;
            max-height: 56px;
            object-fit: contain;
            display: block;
        }

        .partner-card__logo-placeholder {
            color: #666;
            font-size: 0.9rem;
            text-align: center;
            line-height: 1.3;
        }

        .partner-card__body {
            padding: 14px 16px 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .partner-card__title {
            margin: 0;
            font-size: 0.98rem;
            font-weight: 650;
            color: var(--realblack);
        }

        .partner-card__meta {
            font-size: 0.85rem;
            color: #666;
            word-break: break-word;
        }

        @media (max-width: 1024px) {
            .partners-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        @media (max-width: 768px) {
            .partners-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 520px) {
            .partners-grid { grid-template-columns: 1fr; }
        }
    </style>
</div>

