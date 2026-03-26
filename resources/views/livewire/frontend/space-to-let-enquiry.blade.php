<div class="space-enquiry">
    <h3 class="space-enquiry__title">Request a quote / Schedule a viewing</h3>
    <p class="space-enquiry__subtitle">
        Tell us what you need and we’ll respond quickly with options.
    </p>

    <form wire:submit="submit" class="space-enquiry__form">
        <div class="space-enquiry__grid">
            <div class="space-enquiry__group">
                <label for="stl_name">Name</label>
                <input id="stl_name" type="text" wire:model="name" class="space-enquiry__control">
                @error('name')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
            <div class="space-enquiry__group">
                <label for="stl_company">Company (optional)</label>
                <input id="stl_company" type="text" wire:model="company" class="space-enquiry__control">
                @error('company')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="space-enquiry__grid">
            <div class="space-enquiry__group">
                <label for="stl_email">Email</label>
                <input id="stl_email" type="email" wire:model="email" class="space-enquiry__control">
                @error('email')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
            <div class="space-enquiry__group">
                <label for="stl_phone">Phone (optional)</label>
                <input id="stl_phone" type="text" wire:model="phone" class="space-enquiry__control">
                @error('phone')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="space-enquiry__grid">
            <div class="space-enquiry__group">
                <label for="stl_space_needed">Space needed</label>
                <select id="stl_space_needed" wire:model="space_type_id" class="space-enquiry__control">
                    <option value="">Select…</option>
                    @foreach(($spaceTypes ?? collect()) as $type)
                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                </select>
                @error('space_type_id')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
            <div class="space-enquiry__group">
                <label for="stl_budget">Budget range (optional)</label>
                <input id="stl_budget" type="text" wire:model="budget_range" class="space-enquiry__control" placeholder="e.g., 350k–800k RWF / month">
                @error('budget_range')<span class="space-enquiry__error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="space-enquiry__group">
            <label for="stl_timeline">Move-in timeline (optional)</label>
            <input id="stl_timeline" type="text" wire:model="move_in_timeline" class="space-enquiry__control" placeholder="e.g., Immediately / 1 month / 3 months">
            @error('move_in_timeline')<span class="space-enquiry__error">{{ $message }}</span>@enderror
        </div>

        <div class="space-enquiry__group space-enquiry__visit">
            <label class="space-enquiry__checkbox-label" for="stl_visiting">
                <input id="stl_visiting" type="checkbox" wire:model.live="visiting_space" class="space-enquiry__checkbox">
                Visiting the space
            </label>
            @if($visiting_space)
                <div class="space-enquiry__visit-time">
                    <label for="stl_visit_time">Preferred visit time</label>
                    <input id="stl_visit_time" type="text" wire:model="visit_time_preference" class="space-enquiry__control" placeholder="e.g. Tuesday 10am–12pm, or next week">
                    @error('visit_time_preference')<span class="space-enquiry__error">{{ $message }}</span>@enderror
                </div>
            @endif
        </div>

        <div class="space-enquiry__group">
            <label for="stl_message">Message (optional)</label>
            <textarea id="stl_message" rows="4" wire:model="message" class="space-enquiry__control" placeholder="Share size, preferred floor, capacity, etc."></textarea>
            @error('message')<span class="space-enquiry__error">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn-primary space-enquiry__submit" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">Send enquiry</span>
            <span wire:loading wire:target="submit">Sending...</span>
        </button>
    </form>
</div>

