<div>
    <x-page-locator title="Updates" :header="$header ?? null" />
    <div class="content">
        <section class="updates-page">
            <div class="updates-page__inner">
                <header class="updates-page__header">
                    <span class="updates-page__kicker">News &amp; updates</span>
                    <h2 class="updates-page__title">Updates</h2>
                    <p class="updates-page__lead">
                        @if($settings && ($settings->company_name ?? null))
                            News and stories from {{ $settings->company_name }}.
                        @else
                            News and stories from Centenary House.
                        @endif
                    </p>
                </header>

                <div class="updates-placeholder">
                    <div class="updates-placeholder__surface">
                        <span class="updates-placeholder__icon" aria-hidden="true">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M8 7h8M8 11h6"/></svg>
                        </span>
                        <h3 class="updates-placeholder__heading">Coming soon</h3>
                        <p class="updates-placeholder__text">
                            We are preparing news and updates
                            @if($settings && ($settings->company_name ?? null))
                                about {{ $settings->company_name }}.
                            @else
                                about Centenary House.
                            @endif
                            Please check back shortly.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <style>
    .updates-page {
        padding: 24px 0 56px;
        background: linear-gradient(180deg, #fafbfc 0%, #ffffff 32%, #ffffff 100%);
    }

    .updates-page__inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 22px;
    }

    .updates-page__header {
        text-align: center;
        max-width: 720px;
        margin: 0 auto 36px;
        padding: 8px 8px 0;
    }

    .updates-page__kicker {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.16em;
        margin-bottom: 10px;
    }

    .updates-page__title {
        margin: 0 0 14px;
        font-size: clamp(1.45rem, 2.8vw, 1.85rem);
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--realblack);
        line-height: 1.2;
        position: relative;
        padding-bottom: 10px;
    }

    .updates-page__title::after {
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

    .updates-page__lead {
        margin: 16px 0 0;
        font-size: 0.96rem;
        color: #64748b;
        line-height: 1.7;
    }

    .updates-placeholder {
        display: flex;
        justify-content: center;
    }

    .updates-placeholder__surface {
        position: relative;
        width: 100%;
        max-width: 520px;
        padding: 40px 32px 42px;
        text-align: center;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.07);
        box-shadow:
            0 4px 6px rgba(0, 0, 0, 0.02),
            0 18px 44px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .updates-placeholder__surface::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #5c1304);
        border-radius: 18px 18px 0 0;
    }

    .updates-placeholder__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        margin: 0 auto 18px;
        border-radius: 16px;
        background: var(--primary-light);
        color: var(--primary);
    }

    .updates-placeholder__icon svg {
        display: block;
    }

    .updates-placeholder__heading {
        margin: 0 0 12px;
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--realblack);
    }

    .updates-placeholder__text {
        margin: 0;
        font-size: 0.95rem;
        color: #64748b;
        line-height: 1.65;
    }

    @media (max-width: 600px) {
        .updates-page {
            padding: 16px 0 44px;
        }
        .updates-page__inner {
            padding: 0 16px;
        }
        .updates-placeholder__surface {
            padding: 32px 22px 34px;
        }
    }
    </style>
</div>
