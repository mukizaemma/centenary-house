<div>
<x-page-locator title="Feedback" :header="$header" />
<div class="content">
    <div class="feedback-page">
        @if(session('feedback_success'))
            <div class="alert alert-success">{{ session('feedback_success') }}</div>
        @endif
        <h2 class="section-heading">Make a suggestion / Send feedback</h2>
        <p class="section-sub">We value your feedback</p>
        <form wire:submit="submit" class="feedback-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="full_name">Name</label>
                    <input type="text" id="full_name" wire:model="full_name" class="form-control">
                    @error('full_name')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" wire:model="email" class="form-control">
                    @error('email')<span class="error">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" wire:model="phone" class="form-control">
                    @error('phone')<span class="error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="form-group">
                <label for="message">Message <span class="required">*</span></label>
                <textarea id="message" wire:model="message" class="form-control" rows="5"></textarea>
                @error('message')<span class="error">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Rating (optional)</label>
                <select wire:model="rating_out_of_10" class="form-control" style="max-width:120px">
                    <option value="">--</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}/10</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" wire:model="wants_response">
                    I would like a response
                </label>
            </div>
            @if($wants_response)
                <div class="form-group">
                    <label>Preferred contact</label>
                    <select wire:model="preferred_contact_method" class="form-control" style="max-width:200px">
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="either">Either</option>
                    </select>
                </div>
            @endif
            <button type="submit" class="btn-primary">Submit feedback</button>
        </form>
    </div>
</div>
<style>
.feedback-page { margin: 40px 0; max-width: 640px; }
.alert-success { padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px; }
.feedback-form .form-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 0.9rem; margin-bottom: 6px; }
.form-control { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.95rem; }
.error { font-size: 0.8rem; color: #c00; }
.required { color: #c00; }
.checkbox-label { display: flex; align-items: center; gap: 8px; cursor: pointer; }
</style>
</div>
