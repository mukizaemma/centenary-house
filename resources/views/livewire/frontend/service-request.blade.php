<div class="space-enquiry">
    <h3 class="space-enquiry__title">Request a quote / Schedule a viewing</h3>
    <p class="space-enquiry__subtitle">
        Tell us what you need and we’ll respond quickly about <strong>{{ $service->title }}</strong>.
    </p>

    <form wire:submit="submit" class="space-enquiry__form">
        <div class="space-enquiry__grid">
            <div class="space-enquiry__group">
                <label for="sr_name">Name</label>
                <input id="sr_name" type="text" wire:model="name" class="space-enquiry__control" autocomplete="name">
                @error('name')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
            <div class="space-enquiry__group">
                <label for="sr_company">Company (optional)</label>
                <input id="sr_company" type="text" wire:model="company" class="space-enquiry__control" autocomplete="organization">
                @error('company')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="space-enquiry__grid">
            <div class="space-enquiry__group">
                <label for="sr_email">Email</label>
                <input id="sr_email" type="email" wire:model="email" class="space-enquiry__control" autocomplete="email">
                @error('email')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
            <div class="space-enquiry__group">
                <label for="sr_phone">Phone (optional)</label>
                <input id="sr_phone" type="text" wire:model="phone" class="space-enquiry__control" autocomplete="tel">
                @error('phone')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="space-enquiry__grid">
            <div class="space-enquiry__group">
                <span class="space-enquiry__label">Service</span>
                <div class="space-enquiry__readonly">{{ $service->title }}</div>
            </div>
            <div class="space-enquiry__group">
                <label for="sr_budget">Budget range (optional)</label>
                <input id="sr_budget" type="text" wire:model="budget_range" class="space-enquiry__control" placeholder="e.g., 350k–800k RWF / month">
                @error('budget_range')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="space-enquiry__group">
            <label for="sr_timeline">Timeline (optional)</label>
            <input id="sr_timeline" type="text" wire:model="move_in_timeline" class="space-enquiry__control" placeholder="e.g., Immediately / 1 month / 3 months">
            @error('move_in_timeline')<span class="space-enquiry__error">{{ $message }}</span>@enderror
        </div>

        <div class="space-enquiry__group space-enquiry__visit">
            <label class="space-enquiry__checkbox-label" for="sr_visiting">
                <input id="sr_visiting" type="checkbox" wire:model.live="visiting_space" class="space-enquiry__checkbox">
                Visiting the space
            </label>
            @if($visiting_space)
                <div class="space-enquiry__visit-time">
                    <label for="sr_visit_time">Preferred visit time</label>
                    <input id="sr_visit_time" type="text" wire:model="visit_time_preference" class="space-enquiry__control" placeholder="e.g. Tuesday 10am–12pm, or next week">
                    @error('visit_time_preference')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                </div>
            @endif
        </div>

        <div class="space-enquiry__group">
            <label for="sr_message">Message (optional)</label>
            <textarea id="sr_message" rows="4" wire:model="message" class="space-enquiry__control" placeholder="Questions or requirements for this service"></textarea>
            @error('message')<span class="space-enquiry__error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn-primary space-enquiry__submit" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">Send enquiry</span>
            <span wire:loading wire:target="submit">Sending...</span>
        </button>
    </form>
</div>
