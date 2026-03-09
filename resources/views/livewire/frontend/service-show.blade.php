<div>
    <x-page-locator :title="$service->title" :image="$service->cover_image" />
    <div class="content">
        <section class="service-detail">
            <div class="service-detail__body service-detail__body--full">
                @if($service->description)
                    <div class="service-detail__text">
                        {!! $service->description !!}
                    </div>
                @endif

                <div class="service-detail__request">
                    @livewire('frontend.service-request', ['service' => $service])
                </div>

                @if(isset($otherServices) && $otherServices->isNotEmpty())
                    <div class="service-detail__others">
                        <div class="service-detail__others-header">
                            <h2 class="service-detail__others-title">Other services</h2>
                            <p class="service-detail__others-sub">
                                Explore additional services available at {{ $settings->company_name ?? 'Centenary House' }}.
                            </p>
                        </div>

                        <div class="service-detail__others-grid">
                            @foreach($otherServices as $other)
                                <article class="service-detail__card">
                                    <div class="service-detail__card-cover">
                                        @if($other->cover_image)
                                            <img src="{{ asset($other->cover_image) }}" alt="{{ $other->title }}">
                                        @else
                                            <div class="service-detail__card-cover-placeholder"></div>
                                        @endif
                                    </div>
                                    <div class="service-detail__card-body">
                                        <h3 class="service-detail__card-title">{{ $other->title }}</h3>
                                        @if($other->description)
                                            <p class="service-detail__card-excerpt">
                                                {!! \Illuminate\Support\Str::limit(strip_tags($other->description), 120) !!}
                                            </p>
                                        @endif
                                        <a href="{{ route('public.services.show', $other->slug) }}"
                                           wire:navigate
                                           class="btn-primary service-detail__card-button">
                                            View details
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <style>
    .service-detail {
        padding: 30px 0 40px;
    }

    .service-detail__header {
        margin-bottom: 20px;
    }

    .service-detail__header-image {
        border-radius: 14px;
        overflow: hidden;
        background: #f5f5f5;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
        max-height: 380px;
    }

    .service-detail__header-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .service-detail__title {
        font-size: 1.6rem;
        font-weight: 600;
        margin: 16px 0 0;
        color: var(--realblack);
    }

    .service-detail__body--full {
        font-size: 0.95rem;
        color: #555;
        line-height: 1.8;
        width: 80%;
        margin: 0 auto;
    }

    .service-detail__body--full p {
        margin-bottom: 1em;
    }

    .service-detail__request {
        margin-top: 28px;
    }

    .service-detail__others {
        margin-top: 40px;
    }

    .service-detail__others-header {
        margin-bottom: 18px;
    }

    .service-detail__others-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0 0 4px;
        color: var(--realblack);
    }

    .service-detail__others-sub {
        font-size: 0.9rem;
        color: #666;
        margin: 0;
    }

    .service-detail__others-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }

    .service-detail__card {
        background: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 18px -4px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .service-detail__card-cover {
        height: 170px;
        background: #f5f5f5;
        overflow: hidden;
    }

    .service-detail__card-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .service-detail__card:hover .service-detail__card-cover img {
        transform: scale(1.05);
    }

    .service-detail__card-cover-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
    }

    .service-detail__card-body {
        padding: 14px 16px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .service-detail__card-title {
        font-size: 0.98rem;
        font-weight: 600;
        margin: 0;
        color: var(--realblack);
    }

    .service-detail__card-excerpt {
        font-size: 0.88rem;
        color: #555;
        line-height: 1.6;
        margin: 0;
    }

    .service-detail__card-button {
        margin-top: 8px;
        align-self: flex-start;
    }

    @media (max-width: 992px) {
        .service-detail__others-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .service-detail__body--full {
            width: 100%;
        }

        .service-detail__others-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }
    </style>
</div>

