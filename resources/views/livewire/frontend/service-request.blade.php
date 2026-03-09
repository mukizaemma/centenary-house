<div>
    <div class="service-request">
        <h2 class="service-request__title">Request this service</h2>
        <p class="service-request__subtitle">
            Fill in your details below and we will contact you about
            <strong>{{ $service->title }}</strong>.
        </p>

        @if(session('service_request_success'))
            <div class="service-request__alert">
                {{ session('service_request_success') }}
            </div>
        @endif

        <form wire:submit="submit" class="service-request__form">
            <div class="service-request__grid">
                <div class="service-request__group">
                    <label for="sr_first_name">First name</label>
                    <input id="sr_first_name" type="text" wire:model="first_name" class="service-request__control">
                    @error('first_name')<span class="service-request__error">{{ $message }}</span>@enderror
                </div>
                <div class="service-request__group">
                    <label for="sr_last_name">Last name</label>
                    <input id="sr_last_name" type="text" wire:model="last_name" class="service-request__control">
                    @error('last_name')<span class="service-request__error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="service-request__grid">
                <div class="service-request__group">
                    <label for="sr_email">Email</label>
                    <input id="sr_email" type="email" wire:model="email" class="service-request__control">
                    @error('email')<span class="service-request__error">{{ $message }}</span>@enderror
                </div>
                <div class="service-request__group">
                    <label for="sr_phone">Phone (optional)</label>
                    <input id="sr_phone" type="text" wire:model="phone" class="service-request__control">
                    @error('phone')<span class="service-request__error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="service-request__group">
                <label for="sr_message">Message</label>
                <textarea id="sr_message" rows="4" wire:model="message" class="service-request__control"></textarea>
                @error('message')<span class="service-request__error">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="btn-primary service-request__submit" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="submit">Send request</span>
                <span wire:loading wire:target="submit">Sending...</span>
            </button>
        </form>
    </div>

    <style>
        .service-request {
            padding: 22px 20px 24px;
            margin-top: 8px;
            border-radius: 14px;
            background: #f7f7f8;
            border: 1px solid #e5e5e7;
        }

        .service-request__title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 4px;
            color: var(--realblack);
        }

        .service-request__subtitle {
            font-size: 0.9rem;
            color: #666;
            margin: 0 0 16px;
        }

        .service-request__alert {
            padding: 12px 14px;
            margin-bottom: 18px;
            border-radius: 8px;
            background: #d4edda;
            color: #155724;
            font-size: 0.9rem;
        }

        .service-request__form {
            margin-top: 4px;
        }

        .service-request__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        @media (max-width: 640px) {
            .service-request__grid {
                grid-template-columns: 1fr;
            }
        }

        .service-request__group {
            margin-bottom: 14px;
        }

        .service-request__group label {
            display: block;
            font-size: 0.85rem;
            margin-bottom: 4px;
            color: #555;
        }

        .service-request__control {
            width: 100%;
            padding: 9px 11px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.9rem;
            font-family: inherit;
            box-sizing: border-box;
        }

        .service-request__control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .service-request__control::placeholder {
            color: #aaa;
        }

        .service-request__control[type="text"],
        .service-request__control[type="email"] {
            height: 38px;
        }

        .service-request__error {
            display: block;
            margin-top: 3px;
            font-size: 0.8rem;
            color: #c00;
        }

        .service-request__submit {
            margin-top: 6px;
            width: auto;
            min-width: 180px;
            padding-left: 22px;
            padding-right: 22px;
            display: inline-flex;
            justify-content: center;
        }
    </style>
</div>

