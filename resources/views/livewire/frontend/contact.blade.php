<div>
<x-page-locator title="Contact us" :header="$header" />
<div class="content">
    <div class="contact-page">
        {{-- Contact info header --}}
        @if($settings && ($settings->address || $settings->phone_reception || $settings->phone_urgency || $settings->email))
            <div class="contact-info-header">
                @if($settings->address)
                    <div class="contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        </span>
                        <div>
                            <span class="contact-label">ADDRESS</span>
                            <span class="contact-value">{{ $settings->address }}</span>
                        </div>
                    </div>
                @endif
                @if($settings->phone_reception || $settings->phone_urgency)
                    <div class="contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <div>
                            <span class="contact-label">PHONE</span>
                            <span class="contact-value">
                                @if($settings->phone_reception)<a href="tel:{{ $settings->phone_reception }}">{{ $settings->phone_reception }}</a>@endif
                                @if($settings->phone_reception && $settings->phone_urgency) · @endif
                                @if($settings->phone_urgency)<a href="tel:{{ $settings->phone_urgency }}">{{ $settings->phone_urgency }}</a>@endif
                            </span>
                        </div>
                    </div>
                @endif
                @if($settings->email)
                    <div class="contact-info-item">
                        <span class="contact-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <div>
                            <span class="contact-label">EMAIL</span>
                            <span class="contact-value"><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></span>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Get in Touch form --}}
        <div class="contact-form-section">
            <h2 class="contact-form-title">GET IN TOUCH</h2>
            <p class="contact-form-sub">Write us a Message!</p>

            @if(session('contact_success'))
                <div class="alert alert-success">{{ session('contact_success') }}</div>
            @endif

            <form wire:submit="submit" class="contact-form">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="first_name" wire:model="first_name" class="form-control" placeholder="First Name">
                        @error('first_name')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" id="last_name" wire:model="last_name" class="form-control" placeholder="Last Name">
                        @error('last_name')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="phone" wire:model="phone" class="form-control" placeholder="Phone">
                        @error('phone')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" wire:model="email" class="form-control" placeholder="Email">
                        @error('email')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="subject" wire:model="subject" class="form-control" placeholder="Subject">
                    @error('subject')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <textarea id="message" wire:model="message" class="form-control" rows="5" placeholder="Write a message here..."></textarea>
                    @error('message')<span class="error">{{ $message }}</span>@enderror
                </div>
                <button type="submit" class="btn-send-message" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submit">Send message</span>
                    <span wire:loading wire:target="submit">Sending...</span>
                </button>
            </form>
        </div>

        {{-- Google Map --}}
        @if($settings && $settings->map_embed_url)
            @php
                $mapUrl = $settings->map_embed_url;
                if (preg_match('/src=["\']([^"\']+)["\']/', $mapUrl, $m)) {
                    $mapUrl = $m[1];
                }
            @endphp
            <div class="contact-map-section">
                <div class="contact-map-wrapper">
                    <iframe
                        src="{{ $mapUrl }}"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Location map"
                    ></iframe>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.contact-page { margin: 40px 0 60px; }
.contact-info-header {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 24px;
    margin-bottom: 48px;
    padding: 32px 24px;
    background: var(--white);
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.contact-info-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}
.contact-icon {
    flex-shrink: 0;
    color: var(--realblack);
    display: flex;
    align-items: center;
    justify-content: center;
}
.contact-icon svg { width: 24px; height: 24px; }
.contact-label {
    display: block;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    color: #888;
    margin-bottom: 4px;
}
.contact-value {
    font-size: 0.95rem;
    color: var(--realblack);
    line-height: 1.5;
}
.contact-value a { color: var(--realblack); text-decoration: none; }
.contact-value a:hover { color: var(--primary); }

.contact-form-section {
    max-width: 720px;
    margin: 0 auto 48px;
}
.contact-form-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 0.02em;
    margin: 0 0 8px 0;
}
.contact-form-sub {
    font-size: 0.95rem;
    color: #666;
    margin: 0 0 28px 0;
}
.alert-success {
    padding: 14px 18px;
    background: #d4edda;
    color: #155724;
    border-radius: 8px;
    margin-bottom: 24px;
    font-size: 0.95rem;
}
.contact-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
@media (max-width: 600px) {
    .contact-form .form-row { grid-template-columns: 1fr; }
}
.contact-form .form-group { margin-bottom: 20px; }
.contact-form .form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 0.95rem;
    font-family: inherit;
    transition: border-color 0.2s;
}
.contact-form .form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}
.contact-form .form-control::placeholder { color: #aaa; }
.contact-form textarea.form-control { resize: vertical; min-height: 120px; }
.contact-form .error { font-size: 0.8rem; color: #c00; display: block; margin-top: 4px; }
.btn-send-message {
    width: 100%;
    padding: 14px 24px;
    border: none;
    border-radius: 6px;
    background: var(--primary);
    color: var(--white);
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: background 0.3s;
}
.btn-send-message:hover:not(:disabled) { background: var(--primary-dark); }
.btn-send-message:disabled { opacity: 0.7; cursor: not-allowed; }

.contact-map-section { margin-top: 48px; }
.contact-map-wrapper {
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.contact-map-wrapper iframe { display: block; }
</style>
</div>
