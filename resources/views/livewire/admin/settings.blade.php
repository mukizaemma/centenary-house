@section('title', 'Website Settings')

<div>
    <div class="bg-light rounded p-4">
        <h4 class="mb-4">Website Settings</h4>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link {{ $activeTab === 'account' ? 'active' : '' }}"
                    wire:click="setTab('account')"
                    type="button"
                    role="tab"
                >
                    <i class="fa fa-user-circle me-2"></i>Admin Account
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link {{ $activeTab === 'contacts' ? 'active' : '' }}"
                    wire:click="setTab('contacts')"
                    type="button"
                    role="tab"
                >
                    <i class="fa fa-phone-alt me-2"></i>Contact Details
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link {{ $activeTab === 'info' ? 'active' : '' }}"
                    wire:click="setTab('info')"
                    type="button"
                    role="tab"
                >
                    <i class="fa fa-building me-2"></i>Business Info
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Account Tab -->
            <div class="tab-pane fade {{ $activeTab === 'account' ? 'show active' : '' }}" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fa fa-user-circle me-2 text-primary"></i>Hospital User Account
                        </h5>

                        <form wire:submit.prevent="saveAccount">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input
                                        type="text"
                                        class="form-control @error('account_name') is-invalid @enderror"
                                        wire:model.defer="account_name"
                                    >
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control @error('account_email') is-invalid @enderror"
                                        wire:model.defer="account_email"
                                    >
                                    @error('account_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input
                                        type="text"
                                        class="form-control @error('account_phone') is-invalid @enderror"
                                        wire:model.defer="account_phone"
                                    >
                                    @error('account_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Biography</label>
                                <textarea
                                    class="form-control summernote @error('account_biography') is-invalid @enderror"
                                    wire:model.defer="account_biography"
                                ></textarea>
                                @error('account_biography')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        New Password
                                        <small class="text-muted">(leave blank to keep current)</small>
                                    </label>
                                    <input
                                        type="password"
                                        class="form-control @error('account_password') is-invalid @enderror"
                                        wire:model.defer="account_password"
                                    >
                                    @error('account_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        wire:model.defer="account_password_confirmation"
                                    >
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-2"></i>Save Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contacts Tab -->
            <div class="tab-pane fade {{ $activeTab === 'contacts' ? 'show active' : '' }}" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fa fa-phone-alt me-2 text-primary"></i>Contact Details
                        </h5>

                        <form wire:submit.prevent="saveContacts">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">General Email</label>
                                    <input
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        wire:model.defer="email"
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Enquiry Phone (used for WhatsApp)</label>
                                    <input
                                        type="text"
                                        class="form-control @error('phone_reception') is-invalid @enderror"
                                        wire:model.defer="phone_reception"
                                    >
                                    @error('phone_reception')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Manager's Phone</label>
                                    <input
                                        type="text"
                                        class="form-control @error('phone_urgency') is-invalid @enderror"
                                        wire:model.defer="phone_urgency"
                                    >
                                    @error('phone_urgency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea
                                    class="form-control summernote @error('address') is-invalid @enderror"
                                    wire:model.defer="address"
                                ></textarea>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Google Map Embed URL</label>
                                <textarea
                                    class="form-control @error('map_embed_url') is-invalid @enderror"
                                    wire:model.defer="map_embed_url"
                                    rows="3"
                                    placeholder="Paste the full iframe src URL from Google Maps (Share → Embed a map)"
                                ></textarea>
                                <small class="text-muted">Get this from Google Maps: Share → Embed a map → copy the src URL from the iframe.</small>
                                @error('map_embed_url')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-2"></i>Save Contacts
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Business Info Tab -->
            <div class="tab-pane fade {{ $activeTab === 'info' ? 'show active' : '' }}" role="tabpanel">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fa fa-building me-2 text-primary"></i>Business Information
                        </h5>

                        <form wire:submit.prevent="saveInfo">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Business Name</label>
                                    <input
                                        type="text"
                                        class="form-control @error('company_name') is-invalid @enderror"
                                        wire:model.defer="company_name"
                                    >
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Business Logo</label>
                                    <input
                                        type="file"
                                        class="form-control @error('logo') is-invalid @enderror"
                                        wire:model="logo"
                                        accept="image/*"
                                    >
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($logo)
                                        <div class="mt-2">
                                            <span class="text-muted small d-block mb-1">Logo preview (new upload):</span>
                                            <img src="{{ $logo->temporaryUrl() }}" alt="Logo preview" class="img-fluid rounded border" style="max-height: 80px;">
                                        </div>
                                    @elseif($logo_path)
                                        <div class="mt-2">
                                            <span class="text-muted small d-block mb-1">Current logo:</span>
                                            <img src="{{ asset($logo_path) }}" alt="Current logo" class="img-fluid rounded border" style="max-height: 80px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Partner Logo</label>
                                    <input
                                        type="file"
                                        class="form-control @error('partner_logo') is-invalid @enderror"
                                        wire:model="partner_logo"
                                        accept="image/*"
                                    >
                                    @error('partner_logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($partner_logo)
                                        <div class="mt-2">
                                            <span class="text-muted small d-block mb-1">Partner logo preview (new upload):</span>
                                            <img src="{{ $partner_logo->temporaryUrl() }}" alt="Partner logo preview" class="img-fluid rounded border" style="max-height: 80px;">
                                        </div>
                                    @elseif($partner_logo_path)
                                        <div class="mt-2">
                                            <span class="text-muted small d-block mb-1">Current partner logo:</span>
                                            <img src="{{ asset($partner_logo_path) }}" alt="Current partner logo" class="img-fluid rounded border" style="max-height: 80px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Home Background Image</label>
                                    <input
                                        type="file"
                                        class="form-control @error('home_background_image') is-invalid @enderror"
                                        wire:model="home_background_image"
                                        accept="image/*"
                                    >
                                    @error('home_background_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($home_background_image)
                                        <div class="mt-2">
                                            <span class="text-muted small d-block mb-1">Background preview (new upload):</span>
                                            <img src="{{ $home_background_image->temporaryUrl() }}" alt="Background preview" class="img-fluid rounded border" style="max-height: 120px;">
                                        </div>
                                    @elseif($home_background_image_path)
                                        <div class="mt-2">
                                            <span class="text-muted small d-block mb-1">Current background image:</span>
                                            <img src="{{ asset($home_background_image_path) }}" alt="Current background" class="img-fluid rounded border" style="max-height: 120px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Background Image Caption</label>
                                    <textarea
                                        class="form-control summernote @error('home_background_text') is-invalid @enderror"
                                        wire:model.defer="home_background_text"
                                    ></textarea>
                                    @error('home_background_text')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Company Description</label>
                                <textarea
                                    class="form-control summernote @error('about_description') is-invalid @enderror"
                                    wire:model.defer="about_description"
                                ></textarea>
                                @error('about_description')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Company History</label>
                                <textarea
                                    class="form-control summernote @error('about_history') is-invalid @enderror"
                                    wire:model.defer="about_history"
                                ></textarea>
                                @error('about_history')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mission</label>
                                    <textarea
                                        class="form-control summernote @error('mission') is-invalid @enderror"
                                        wire:model.defer="mission"
                                    ></textarea>
                                    @error('mission')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Vision</label>
                                    <textarea
                                        class="form-control summernote @error('vision') is-invalid @enderror"
                                        wire:model.defer="vision"
                                    ></textarea>
                                    @error('vision')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quote</label>
                                <textarea
                                    class="form-control summernote @error('home_quote') is-invalid @enderror"
                                    wire:model.defer="home_quote"
                                ></textarea>
                                @error('home_quote')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Facebook URL</label>
                                    <input
                                        type="url"
                                        class="form-control @error('facebook_url') is-invalid @enderror"
                                        wire:model.defer="facebook_url"
                                    >
                                    @error('facebook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Instagram URL</label>
                                    <input
                                        type="url"
                                        class="form-control @error('instagram_url') is-invalid @enderror"
                                        wire:model.defer="instagram_url"
                                    >
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">LinkedIn URL</label>
                                    <input
                                        type="url"
                                        class="form-control @error('linkedin_url') is-invalid @enderror"
                                        wire:model.defer="linkedin_url"
                                    >
                                    @error('linkedin_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">YouTube URL</label>
                                    <input
                                        type="url"
                                        class="form-control @error('youtube_url') is-invalid @enderror"
                                        wire:model.defer="youtube_url"
                                    >
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">X (Twitter) URL</label>
                                    <input
                                        type="url"
                                        class="form-control @error('x_url') is-invalid @enderror"
                                        wire:model.defer="x_url"
                                    >
                                    @error('x_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Threads URL</label>
                                    <input
                                        type="url"
                                        class="form-control @error('threads_url') is-invalid @enderror"
                                        wire:model.defer="threads_url"
                                    >
                                    @error('threads_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save me-2"></i>Save Business Info
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
