<div>
<x-page-locator title="Appointment" :header="$header" />
<div class="content">
    <div class="appointment-page">
        <p class="lead">To book an appointment, please contact us using the details below or submit your feedback and we will get back to you.</p>
        @if($settings)
            <div class="contact-grid">
                @if($settings->phone_reception || $settings->phone_urgency)
                    <div class="contact-card">
                        <h3>Call us</h3>
                        <p>
                            @if($settings->phone_reception)<a href="tel:{{ $settings->phone_reception }}">{{ $settings->phone_reception }}</a> (Reception)<br>@endif
                            @if($settings->phone_urgency)<a href="tel:{{ $settings->phone_urgency }}">{{ $settings->phone_urgency }}</a> (Emergency)@endif
                        </p>
                    </div>
                @endif
                @if($settings->email)
                    <div class="contact-card">
                        <h3>Email</h3>
                        <p><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></p>
                    </div>
                @endif
            </div>
        @endif
        <div class="mt-4">
            <a href="{{ route('feedback') }}" class="btn-primary" wire:navigate>Submit feedback / request</a>
        </div>
    </div>
</div>
<style>
.appointment-page { margin: 40px 0; }
.lead { font-size: 1rem; color: #555; margin-bottom: 24px; line-height: 1.6; }
.contact-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 24px; }
.contact-card { padding: 24px; background: #f9f9f9; border-radius: 8px; }
.contact-card h3 { font-size: 1rem; margin-bottom: 12px; color: var(--primary); }
.contact-card a { color: var(--primary); text-decoration: none; }
.mt-4 { margin-top: 24px; }
</style>
</div>
