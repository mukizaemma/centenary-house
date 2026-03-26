<div>
    <x-page-locator title="Book a tour visit" :header="$header ?? null" />
    <div class="content">
        <section class="book-tour-page">
            <div class="book-tour__intro">
                <h2 class="book-tour__title">Schedule a visit</h2>
                <p class="book-tour__subtitle">
                    Tell us what you need and we’ll confirm a convenient time. Find us on the map below.
                </p>
            </div>

            <div class="space-landing__bottom">
                <div id="space-enquiry" class="space-landing__enquiry">
                    <livewire:frontend.space-to-let-enquiry :space-type-id="$preselectedSpaceTypeId" />
                </div>
                <x-google-map-embed
                    class="space-landing__map-panel"
                    :embed="$effectiveMapUrl"
                    :min-height="380"
                    title="Centenary House location map"
                    empty-message="Add a Google Maps embed URL in Admin to display location here."
                />
            </div>
        </section>
    </div>

    <style>
    .book-tour-page {
        padding: 10px 0 40px;
        max-width: 1240px;
        margin: 0 auto;
    }
    .book-tour__intro {
        max-width: 720px;
        margin: 0 auto 22px;
        padding: 0 22px;
        text-align: center;
    }
    .book-tour__title {
        margin: 0 0 8px;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--realblack);
    }
    .book-tour__subtitle {
        margin: 0;
        font-size: 0.95rem;
        color: #555;
        line-height: 1.65;
    }
    .space-landing__bottom {
        margin: 18px 0 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        align-items: stretch;
        padding: 0 22px;
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
    @media (max-width: 992px) {
        .space-landing__bottom {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 600px) {
        .book-tour__intro { padding: 0 16px; }
        .space-landing__bottom { padding: 0 16px; }
    }
    </style>
</div>
