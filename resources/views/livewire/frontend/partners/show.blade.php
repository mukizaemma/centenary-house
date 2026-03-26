<div>
    <x-page-locator :title="$partner->name" />
    <div class="content">
        <section class="partner-detail">
            <div class="partner-detail__card">
                <div class="partner-detail__logo">
                    @if($partner->logo_path)
                        <img src="{{ asset($partner->logo_path) }}" alt="{{ $partner->name }}">
                    @endif
                </div>

                <div class="partner-detail__body">
                    <h2 class="partner-detail__title">{{ $partner->name }}</h2>

                    @if($partner->website_url)
                        <a class="partner-detail__website" href="{{ $partner->website_url }}" target="_blank" rel="noopener">
                            Visit website
                        </a>
                    @endif

                    @if($partner->description)
                        <div class="partner-detail__desc">
                            {!! $partner->description !!}
                        </div>
                    @else
                        <p class="partner-detail__empty">No description provided.</p>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <style>
        .partner-detail { padding: 30px 0 44px; }
        .partner-detail__card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 22px;
            display: grid;
            grid-template-columns: 220px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }
        .partner-detail__logo {
            background: #fafafa;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 14px;
            padding: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 140px;
        }
        .partner-detail__logo img { max-width: 100%; max-height: 90px; object-fit: contain; display: block; }
        .partner-detail__title { margin: 0 0 10px; font-size: 1.6rem; font-weight: 700; color: var(--realblack); }
        .partner-detail__website { display: inline-flex; text-decoration: none; color: var(--primary); font-weight: 650; }
        .partner-detail__website:hover { text-decoration: underline; }
        .partner-detail__desc { margin-top: 14px; color: #444; line-height: 1.8; }
        .partner-detail__empty { margin-top: 14px; color: #666; }
        @media (max-width: 900px) {
            .partner-detail__card { grid-template-columns: 1fr; }
        }
    </style>
</div>

