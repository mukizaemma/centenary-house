<div>
    <x-page-locator title="Contact us" :header="$header ?? null" />
    <div class="content">
        <div class="contact-page">
            <div class="contact-page__inner">
                <header class="contact-page__header">
                    <span class="contact-page__kicker">Contact</span>
                    <h2 class="contact-page__title">We’d love to hear from you</h2>
                    <p class="contact-page__lead">
                        Questions about offices, services or visiting
                        {{ optional($settings)->company_name ?? 'Centenary House' }}? Send a message — we’ll respond as soon as we can.
                    </p>
                </header>

                @php
                    $hasContactCards = $settings && ($settings->address || $settings->phone_reception || $settings->phone_urgency || $settings->email);
                @endphp
                <div class="contact-page__grid {{ $hasContactCards ? '' : 'contact-page__grid--solo' }}">
                    @if($hasContactCards)
                        <aside class="contact-page__aside">
                            @if($settings->address)
                                <div class="contact-page__card">
                                    <span class="contact-page__card-icon" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    </span>
                                    <div class="contact-page__card-body">
                                        <div class="contact-page__card-label">Address</div>
                                        <div class="contact-page__card-value contact-page__address">{!! $settings->address !!}</div>
                                    </div>
                                </div>
                            @endif
                            @if($settings->phone_reception || $settings->phone_urgency)
                                <div class="contact-page__card">
                                    <span class="contact-page__card-icon" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    </span>
                                    <div class="contact-page__card-body">
                                        <div class="contact-page__card-label">Phone</div>
                                        <div class="contact-page__card-value">
                                            @if($settings->phone_reception)
                                                <a href="tel:{{ $settings->phone_reception }}">{{ $settings->phone_reception }}</a>
                                            @endif
                                            @if($settings->phone_reception && $settings->phone_urgency)
                                                <span class="contact-page__sep">·</span>
                                            @endif
                                            @if($settings->phone_urgency)
                                                <a href="tel:{{ $settings->phone_urgency }}">{{ $settings->phone_urgency }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($settings->email)
                                <div class="contact-page__card">
                                    <span class="contact-page__card-icon" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                    </span>
                                    <div class="contact-page__card-body">
                                        <div class="contact-page__card-label">Email</div>
                                        <div class="contact-page__card-value">
                                            <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </aside>
                    @endif

                    <div class="contact-page__form-wrap">
                        <div class="space-enquiry">
                            <h3 class="space-enquiry__title">Send a message</h3>
                            <p class="space-enquiry__subtitle">
                                Share your details and we’ll get back to you shortly.
                            </p>

                            @if(session('contact_success'))
                                <div class="contact-page__flash-success" role="status">{{ session('contact_success') }}</div>
                            @endif

                            <form wire:submit="submit" class="space-enquiry__form">
                                <div class="space-enquiry__grid">
                                    <div class="space-enquiry__group">
                                        <label for="contact_first_name">First name</label>
                                        <input id="contact_first_name" type="text" wire:model="first_name" class="space-enquiry__control" placeholder="First name" autocomplete="given-name">
                                        @error('first_name')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="space-enquiry__group">
                                        <label for="contact_last_name">Last name</label>
                                        <input id="contact_last_name" type="text" wire:model="last_name" class="space-enquiry__control" placeholder="Last name" autocomplete="family-name">
                                        @error('last_name')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="space-enquiry__grid">
                                    <div class="space-enquiry__group">
                                        <label for="contact_phone">Phone <span class="space-enquiry__optional">(optional)</span></label>
                                        <input id="contact_phone" type="text" wire:model="phone" class="space-enquiry__control" placeholder="Phone" autocomplete="tel">
                                        @error('phone')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="space-enquiry__group">
                                        <label for="contact_email">Email</label>
                                        <input id="contact_email" type="email" wire:model="email" class="space-enquiry__control" placeholder="Email" autocomplete="email">
                                        @error('email')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="space-enquiry__group">
                                    <label for="contact_subject">Subject <span class="space-enquiry__optional">(optional)</span></label>
                                    <input id="contact_subject" type="text" wire:model="subject" class="space-enquiry__control" placeholder="e.g. Office viewing">
                                    @error('subject')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                                </div>
                                <div class="space-enquiry__group space-enquiry__visit">
                                    <label class="space-enquiry__checkbox-label" for="contact_visiting">
                                        <input id="contact_visiting" type="checkbox" wire:model.live="visiting_space" class="space-enquiry__checkbox">
                                        Visiting the space
                                    </label>
                                    @if($visiting_space)
                                        <div class="space-enquiry__visit-time">
                                            <label for="contact_visit_time">Preferred visit time</label>
                                            <input id="contact_visit_time" type="text" wire:model="visit_time_preference" class="space-enquiry__control" placeholder="e.g. Tuesday 10am–12pm, or next week">
                                            @error('visit_time_preference')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                                        </div>
                                    @endif
                                </div>
                                <div class="space-enquiry__group">
                                    <label for="contact_message">Message</label>
                                    <textarea id="contact_message" wire:model="message" class="space-enquiry__control" rows="5" placeholder="How can we help?"></textarea>
                                    @error('message')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                                </div>
                                <button type="submit" class="btn-primary space-enquiry__submit" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="submit">Send message</span>
                                    <span wire:loading wire:target="submit">Sending...</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                @if($settings && $settings->map_embed_url)
                    <section class="contact-page__map">
                        <div class="contact-page__map-head">
                            <h3 class="contact-page__map-title">Find us</h3>
                            <p class="contact-page__map-lead">Centenary House on the map</p>
                        </div>
                        <x-google-map-embed
                            :embed="$settings->map_embed_url"
                            :min-height="420"
                            title="{{ ($settings->company_name ?? 'Centenary House') }} — location map"
                        />
                    </section>
                @endif
            </div>
        </div>
    </div>
</div>
