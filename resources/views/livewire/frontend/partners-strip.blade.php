<div>
    @if($partners->count())
        <section class="partners-strip">
            <div class="partners-strip__inner">
                <div class="partners-strip__header">
                    <h3 class="partners-strip__title">Our trusted partners</h3>
                    <a href="{{ route('partners.index') }}" wire:navigate class="partners-strip__view-more">
                        View more
                    </a>
                </div>

                <div class="partners-strip__grid">
                    @foreach($partners as $partner)
                        @php
                            $hasWebsite = !empty($partner->website_url);
                            $href = $hasWebsite ? $partner->website_url : route('partners.show', $partner);
                        @endphp
                        <a
                            class="partners-strip__item"
                            href="{{ $href }}"
                            @if($hasWebsite) target="_blank" rel="noopener" @else wire:navigate @endif
                            aria-label="{{ $partner->name }}"
                            title="{{ $partner->name }}"
                        >
                            @if($partner->logo_path)
                                <img src="{{ asset($partner->logo_path) }}" alt="{{ $partner->name }}" loading="lazy">
                            @else
                                <span class="partners-strip__placeholder">{{ $partner->name }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <style>
        .partners-strip {
            margin: 28px 0 10px;
            padding: 22px 0 6px;
            border-top: 1px solid rgba(0,0,0,0.06);
        }

        .partners-strip__inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 22px;
        }

        .partners-strip__header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .partners-strip__title {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 650;
            color: var(--realblack);
        }

        .partners-strip__view-more {
            font-size: 0.88rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            white-space: nowrap;
        }

        .partners-strip__view-more:hover { text-decoration: underline; }

        .partners-strip__grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 12px 14px;
        }

        .partners-strip__item {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.06);
            padding: 14px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 76px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .partners-strip__item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
            border-color: rgba(0,0,0,0.12);
        }

        .partners-strip__item img {
            max-width: 100%;
            max-height: 44px;
            object-fit: contain;
            display: block;
            filter: saturate(0.95);
        }

        .partners-strip__placeholder {
            font-size: 0.85rem;
            color: #666;
            text-align: center;
            line-height: 1.3;
            padding: 0 6px;
        }

        @media (max-width: 992px) {
            .partners-strip__grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }

        @media (max-width: 640px) {
            .partners-strip__inner { padding: 0 16px; }
            .partners-strip__grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .partners-strip__item { min-height: 70px; }
        }
    </style>
</div>

