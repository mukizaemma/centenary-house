<?php

namespace App\Livewire\Admin;

use App\Models\WebsiteSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class Settings extends Component
{
    use WithFileUploads;

    #[Url(as: 'tab', keep: true)]
    public string $activeTab = 'account';

    // Account tab
    public string $account_name = '';
    public string $account_email = '';
    public ?string $account_phone = null;
    public ?string $account_biography = null;
    public ?string $account_password = null;
    public ?string $account_password_confirmation = null;

    // Contacts tab (website_settings)
    public ?string $email = null;
    public ?string $phone_reception = null; // enquiry phone
    public ?string $phone_urgency = null;   // manager phone
    public ?string $phone_whatsapp = null;  // legacy, no longer used in UI
    public ?string $phone_billing = null;   // legacy
    public ?string $phone_restaurant = null; // legacy
    public ?string $address = null;
    public ?string $map_embed_url = null;

    // Business info tab (website_settings)
    public ?string $company_name = null;
    public ?string $home_background_text = null;
    public ?string $home_quote = null;
    public ?string $about_description = null;
    public ?string $about_history = null;
    public ?string $about_heading = null;
    public ?string $about_values_subheading = null;
    public array $about_value_cards = [];
    public ?string $mission = null;
    public ?string $vision = null;
    public ?string $core_values = null;
    public ?string $facebook_url = null;
    public ?string $instagram_url = null;
    public ?string $linkedin_url = null;
    public ?string $youtube_url = null;
    public ?string $x_url = null;
    public ?string $threads_url = null;
    public ?string $logo_path = null;
    public ?string $partner_logo_path = null;
    public ?string $home_background_image_path = null;
    public ?string $cta_background_image_path = null;
    public ?string $cta_title = null;
    public ?string $cta_description = null;
    public ?string $gallery_external_url = null;

    /**
     * Temporary uploaded files for logo, home background, and CTA background.
     */
    public $logo;
    public $partner_logo;
    public $home_background_image;
    public $cta_background_image;

    // Page headers functionality has been disabled for now
    // to avoid requiring the page_headers table while the
    // new public site is being built.

    public function mount()
    {
        // Validate tab parameter (only account/contacts/info for now)
        $validTabs = ['account', 'contacts', 'info'];
        if (!in_array($this->activeTab, $validTabs)) {
            $this->activeTab = 'account';
        }

        $this->loadAccount();
        $this->loadWebsiteSettings();

        // Initialize rich-text editors on initial load
        $this->dispatch('init-summernote');
    }

    public function setTab(string $tab): void
    {
        $validTabs = ['account', 'contacts', 'info'];
        if (in_array($tab, $validTabs)) {
            $this->activeTab = $tab;
            if ($tab === 'info' || $tab === 'contacts') {
                // Re-initialize editors when switching to tabs with rich-text fields
                $this->dispatch('init-summernote');
            }
        }
    }

    protected function loadAccount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->account_name = $user->name;
        $this->account_email = $user->email;
        $this->account_phone = $user->phone ?? '';
        $this->account_biography = $user->biography ?? '';
    }

    protected function loadWebsiteSettings(): void
    {
        $settings = WebsiteSetting::first();

        if (!$settings) {
            $settings = WebsiteSetting::create([]);
        }

        // Contacts
        $this->email = $settings->email;
        $this->phone_reception = $settings->phone_reception;
        $this->phone_urgency = $settings->phone_urgency;
        $this->phone_whatsapp = $settings->phone_whatsapp;
        $this->phone_billing = $settings->phone_billing;
        $this->phone_restaurant = $settings->phone_restaurant;
        $this->address = $settings->address;
        $this->map_embed_url = $settings->map_embed_url;

        // Hospital info
        $this->company_name = $settings->company_name;
        $this->home_background_text = $settings->home_background_text;
        $this->home_quote = $settings->home_quote;
        $this->about_description = $settings->about_description;
        $this->about_history = $settings->about_history;
        $this->about_heading = $settings->about_heading ?? 'We Collaborate for Better Healthcare';
        $this->about_values_subheading = $settings->about_values_subheading ?? 'The Hospital That Has a Sincere Heart';
        $decoded = $settings->about_value_cards ? (is_string($settings->about_value_cards) ? json_decode($settings->about_value_cards, true) : $settings->about_value_cards) : [];
        $this->about_value_cards = is_array($decoded) ? $decoded : [];
        if (empty($this->about_value_cards)) {
            $this->about_value_cards = [
                ['name' => 'Honesty', 'description' => 'Committed to transparent care, our hospital values honesty in every medical interaction for patient well-being.'],
                ['name' => 'Learning', 'description' => 'Fostering a culture of continuous education, we strive for medical excellence through ongoing learning initiatives.'],
                ['name' => 'Trust', 'description' => 'Patients entrust their health to us; we reciprocate with unwavering commitment, building lasting trust in healthcare.'],
                ['name' => 'Passion', 'description' => 'Our dedicated medical professionals channel passion into every healing moment, ensuring compassionate and personalized patient care.'],
            ];
        }
        $this->mission = $settings->mission;
        $this->vision = $settings->vision;
        $this->core_values = $settings->core_values;
        $this->facebook_url = $settings->facebook_url;
        $this->instagram_url = $settings->instagram_url;
        $this->linkedin_url = $settings->linkedin_url;
        $this->youtube_url = $settings->youtube_url;
        $this->x_url = $settings->x_url;
        $this->threads_url = $settings->threads_url;
        $this->logo_path = $settings->logo_path;
        $this->partner_logo_path = $settings->partner_logo_path;
        $this->home_background_image_path = $settings->home_background_image_path;
        $this->cta_background_image_path = $settings->cta_background_image_path;
        $this->cta_title = $settings->cta_title;
        $this->cta_description = $settings->cta_description;
        $this->gallery_external_url = $settings->gallery_external_url;
    }

    public function saveAccount(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $this->validate([
            'account_name' => ['required', 'string', 'max:255'],
            'account_email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'account_phone' => ['nullable', 'string', 'max:50'],
            'account_biography' => ['nullable', 'string'],
            'account_password' => ['nullable', 'string', 'min:8', 'same:account_password_confirmation'],
        ]);

        $user->name = $validated['account_name'];
        $user->email = $validated['account_email'];
        $user->phone = $validated['account_phone'] ?? null;
        $user->biography = $validated['account_biography'] ?? null;

        if (!empty($validated['account_password'])) {
            $user->password = Hash::make($validated['account_password']);
        }

        $user->save();

        $message = 'Account details updated successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
    }

    public function saveContacts(): void
    {
        $validated = $this->validate([
            'email' => ['nullable', 'email', 'max:255'],
            'phone_reception' => ['nullable', 'string', 'max:50'],
            'phone_urgency' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'map_embed_url' => ['nullable', 'string'],
        ]);

        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([]);
        $settings->update($validated);

        $message = 'Contact details updated successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
    }

    public function saveInfo(): void
    {
        $validated = $this->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'home_background_text' => ['nullable', 'string'],
            'home_quote' => ['nullable', 'string'],
            'about_description' => ['nullable', 'string'],
            'about_history' => ['nullable', 'string'],
            'about_heading' => ['nullable', 'string', 'max:255'],
            'about_values_subheading' => ['nullable', 'string', 'max:255'],
            'about_value_cards' => ['nullable', 'array'],
            'about_value_cards.*.name' => ['nullable', 'string', 'max:100'],
            'about_value_cards.*.description' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'core_values' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'url'],
            'instagram_url' => ['nullable', 'url'],
            'linkedin_url' => ['nullable', 'url'],
            'youtube_url' => ['nullable', 'url'],
            'x_url' => ['nullable', 'url'],
            'threads_url' => ['nullable', 'url'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
            'partner_logo' => ['nullable', 'image', 'max:2048'],
            'home_background_image' => ['nullable', 'image', 'max:4096'], // max 4MB
            'cta_background_image' => ['nullable', 'image', 'max:4096'], // max 4MB
            'cta_title' => ['nullable', 'string', 'max:255'],
            'cta_description' => ['nullable', 'string'],
            'gallery_external_url' => ['nullable', 'string', 'max:500'],
        ]);

        $settings = WebsiteSetting::first() ?? WebsiteSetting::create([]);

        // Fill simple text fields
        $settings->fill([
            'company_name' => $this->company_name,
            'home_background_text' => $this->home_background_text,
            'home_quote' => $this->home_quote,
            'about_description' => $this->about_description,
            'about_history' => $this->about_history,
            'about_heading' => $this->about_heading,
            'about_values_subheading' => $this->about_values_subheading,
            'about_value_cards' => !empty($this->about_value_cards) ? json_encode(array_values(array_filter($this->about_value_cards, fn($c) => !empty($c['name']) || !empty($c['description'])))) : null,
            'mission' => $this->mission,
            'vision' => $this->vision,
            'core_values' => $this->core_values,
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'linkedin_url' => $this->linkedin_url,
            'youtube_url' => $this->youtube_url,
            'x_url' => $this->x_url,
            'threads_url' => $this->threads_url,
            'gallery_external_url' => $this->gallery_external_url,
        ]);

        // Handle logo upload (if a new file was selected)
        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            // Store path in a way that works with asset()
            $settings->logo_path = 'storage/' . $path;
            $this->logo_path = $settings->logo_path;
        }

        // Handle partner logo upload (if a new file was selected)
        if ($this->partner_logo) {
            $partnerPath = $this->partner_logo->store('logos', 'public');
            $settings->partner_logo_path = 'storage/' . $partnerPath;
            $this->partner_logo_path = $settings->partner_logo_path;
        }

        // Handle home background image upload (if a new file was selected)
        if ($this->home_background_image) {
            $bgPath = $this->home_background_image->store('hero', 'public');
            $settings->home_background_image_path = 'storage/' . $bgPath;
            $this->home_background_image_path = $settings->home_background_image_path;
        }

        // CTA section
        $settings->cta_title = $this->cta_title;
        $settings->cta_description = $this->cta_description;
        if ($this->cta_background_image) {
            $ctaPath = $this->cta_background_image->store('cta', 'public');
            $settings->cta_background_image_path = 'storage/' . $ctaPath;
            $this->cta_background_image_path = $settings->cta_background_image_path;
        }

        $settings->save();

        // Clear temporary uploads so the file inputs reset
        $this->logo = null;
        $this->partner_logo = null;
        $this->home_background_image = null;
        $this->cta_background_image = null;

        $message = 'Business information updated successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
    }

    public function addAboutValueCard(): void
    {
        $this->about_value_cards[] = ['name' => '', 'description' => ''];
    }

    public function removeAboutValueCard(int $index): void
    {
        $cards = $this->about_value_cards;
        array_splice($cards, $index, 1);
        $this->about_value_cards = array_values($cards);
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
