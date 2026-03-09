<div class="office-enquiry">
    <h3 class="office-enquiry__title">Office enquiry</h3>
    <p class="office-enquiry__subtitle">
        Tell us what kind of office or space you are looking for and we will get in touch.
    </p>

    @if(session('office_enquiry_success'))
        <div class="office-enquiry__alert">
            {{ session('office_enquiry_success') }}
        </div>
    @endif

    <form wire:submit="submit" class="office-enquiry__form">
        <div class="office-enquiry__grid">
            <div class="office-enquiry__group">
                <label for="oe_first_name">First name</label>
                <input id="oe_first_name" type="text" wire:model="first_name" class="office-enquiry__control">
                @error('first_name')<span class="office-enquiry__error">{{ $message }}</span>@enderror
            </div>
            <div class="office-enquiry__group">
                <label for="oe_last_name">Last name</label>
                <input id="oe_last_name" type="text" wire:model="last_name" class="office-enquiry__control">
                @error('last_name')<span class="office-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="office-enquiry__grid">
            <div class="office-enquiry__group">
                <label for="oe_email">Email</label>
                <input id="oe_email" type="email" wire:model="email" class="office-enquiry__control">
                @error('email')<span class="office-enquiry__error">{{ $message }}</span>@enderror
            </div>
            <div class="office-enquiry__group">
                <label for="oe_phone">Phone (optional)</label>
                <input id="oe_phone" type="text" wire:model="phone" class="office-enquiry__control">
                @error('phone')<span class="office-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="office-enquiry__group">
            <label for="oe_message">What kind of office do you need?</label>
            <textarea id="oe_message" rows="4" wire:model="message" class="office-enquiry__control"></textarea>
            @error('message')<span class="office-enquiry__error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn-primary office-enquiry__submit" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">Send enquiry</span>
            <span wire:loading wire:target="submit">Sending...</span>
        </button>
    </form>

    <style>
        .office-enquiry {
            padding: 18px 18px 20px;
            border-radius: 14px;
            background: #f7f7f8;
            border: 1px solid #e4e4e7;
        }

        .office-enquiry__title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 4px;
            color: var(--realblack);
        }

        .office-enquiry__subtitle {
            font-size: 0.9rem;
            color: #666;
            margin: 0 0 14px;
        }

        .office-enquiry__alert {
            padding: 10px 12px;
            border-radius: 8px;
            background: #d4edda;
            color: #155724;
            font-size: 0.88rem;
            margin-bottom: 14px;
        }

        .office-enquiry__form {
            margin-top: 2px;
        }

        .office-enquiry__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px 16px;
        }

        @media (max-width: 640px) {
            .office-enquiry__grid {
                grid-template-columns: 1fr;
            }
        }

        .office-enquiry__group {
            margin-bottom: 12px;
        }

        .office-enquiry__group label {
            display: block;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 4px;
        }

        .office-enquiry__control {
            width: 100%;
            padding: 9px 11px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.9rem;
            font-family: inherit;
            box-sizing: border-box;
        }

        .office-enquiry__control[type="text"],
        .office-enquiry__control[type="email"] {
            height: 38px;
        }

        .office-enquiry__control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .office-enquiry__error {
            display: block;
            margin-top: 3px;
            font-size: 0.8rem;
            color: #c00;
        }

        .office-enquiry__submit {
            margin-top: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding-left: 22px;
            padding-right: 22px;
            min-width: 170px;
        }
    </style>
</div>

