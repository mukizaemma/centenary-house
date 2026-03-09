<div>
    <x-page-locator title="Updates" :header="$header ?? null" />
    <div class="content">
        <section class="updates-page">
            <div class="updates-inner">
                <h2 class="updates-title">Updates coming soon</h2>
                <p class="updates-sub">
                    We are preparing news and updates about Centenary House. Please check back shortly.
                </p>
            </div>
        </section>
    </div>

    <style>
    .updates-page {
        padding: 60px 0 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .updates-inner {
        text-align: center;
        max-width: 520px;
        margin: 0 auto;
    }

    .updates-title {
        font-size: 1.6rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--realblack);
    }

    .updates-sub {
        font-size: 0.95rem;
        color: #666666;
    }

    @media (max-width: 600px) {
        .updates-page {
            padding: 40px 0 60px;
        }

        .updates-title {
            font-size: 1.3rem;
        }
    }
    </style>
</div>

