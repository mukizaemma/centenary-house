<div class="room-enquiry-form-section">
    <h2 class="room-enquiry-form-title">Request this space</h2>
    <p class="room-enquiry-form-sub">
        Send us a quick enquiry about <strong>{{ $room->title }}</strong>. We will reach out using the details below.
    </p>

    @if(session('room_enquiry_success'))
        <div class="room-enquiry-alert-success">
            {{ session('room_enquiry_success') }}
        </div>
    @endif

    <form wire:submit="submit" class="room-enquiry-form">
        <div class="room-enquiry-row">
            <div class="room-enquiry-group">
                <input
                    type="text"
                    id="re_name"
                    wire:model="name"
                    class="room-enquiry-control"
                    placeholder="Full name"
                >
                @error('name')<span class="room-enquiry-error">{{ $message }}</span>@enderror
            </div>
            <div class="room-enquiry-group">
                <input
                    type="email"
                    id="re_email"
                    wire:model="email"
                    class="room-enquiry-control"
                    placeholder="Email address"
                >
                @error('email')<span class="room-enquiry-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="room-enquiry-row">
            <div class="room-enquiry-group">
                <input
                    type="text"
                    id="re_phone"
                    wire:model="phone"
                    class="room-enquiry-control"
                    placeholder="Phone (optional)"
                >
                @error('phone')<span class="room-enquiry-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="room-enquiry-group">
            <textarea
                id="re_message"
                wire:model="message"
                class="room-enquiry-control room-enquiry-control-textarea"
                rows="4"
                placeholder="Tell us about your needs, preferred size, dates, and any questions you have."
            ></textarea>
            @error('message')<span class="room-enquiry-error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn-primary room-enquiry-submit" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">Send enquiry</span>
            <span wire:loading wire:target="submit">Sending...</span>
        </button>
    </form>

    <style>
        .room-enquiry-form-section {
            max-width: 760px;
            margin: 36px auto 10px;
            padding: 26px 24px 24px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }

        .room-enquiry-form-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin: 0 0 6px 0;
        }

        .room-enquiry-form-sub {
            font-size: 0.94rem;
            color: #555;
            margin: 0 0 20px 0;
        }

        .room-enquiry-alert-success {
            padding: 12px 16px;
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .room-enquiry-form {
            width: 100%;
        }

        .room-enquiry-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 16px;
        }

        @media (max-width: 640px) {
            .room-enquiry-row {
                grid-template-columns: 1fr;
            }
        }

        .room-enquiry-group {
            width: 100%;
        }

        .room-enquiry-control {
            width: 100%;
            padding: 11px 14px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 0.94rem;
            font-family: inherit;
            box-sizing: border-box;
        }

        .room-enquiry-control-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .room-enquiry-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .room-enquiry-control::placeholder {
            color: #aaa;
        }

        .room-enquiry-error {
            display: block;
            margin-top: 4px;
            font-size: 0.8rem;
            color: #c00;
        }

        .room-enquiry-submit {
            width: 100%;
            justify-content: center;
            margin-top: 4px;
            padding-top: 12px;
            padding-bottom: 12px;
        }
    </style>
</div>

