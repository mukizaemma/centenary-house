<?php

namespace App\Livewire\Admin\SpaceToLetPage;

use App\Models\SpaceToLetPage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithFileUploads;

    public ?int $editingId = null;

    public ?string $hero_title = null;
    public ?string $hero_subtitle = null;
    public string $hero_bullets_text = '';

    public ?string $location_title = null;
    public ?string $location_html = null;
    public ?string $google_map_embed_url = null;

    public string $amenities_text = '';

    public array $gallery = [];
    public array $existing_gallery_images = [];

    public ?string $pricing_html = null;
    public ?string $cta_primary_text = null;
    public ?string $cta_primary_url = null;

    public string $ideal_for_text = '';

    public bool $is_active = true;

    public function mount(): void
    {
        $page = SpaceToLetPage::query()->orderByDesc('id')->first();
        if ($page) {
            $this->editingId = $page->id;
            $this->fillFromModel($page);
        } else {
            // sensible defaults
            $this->hero_title = 'Flexible Office Spaces at Centenary House — From Private Offices to Full Floors in the Heart of Kigali';
            $this->hero_subtitle = 'Prime location, flexible options, and a professional environment designed for modern teams.';
            $this->hero_bullets_text = "Prime location in Kigali\nFlexible offices (private → full floor)\nProfessional environment\nAccessibility & amenities";

            $this->location_title = 'Location & accessibility';

            $this->amenities_text = "24/7 security\nReception services\nBackup power\nParking\nElevators\nCleaning services";
            $this->pricing_html = '<p><strong>Starting from 350,000 RWF/month</strong>. Custom pricing based on size and requirements.</p>';
            $this->cta_primary_text = 'Schedule a viewing';
            $this->cta_primary_url = route('contact');

            $this->ideal_for_text = "Startups\nNGOs\nCorporate offices\nConsultants";
        }
    }

    protected function rules(): array
    {
        return [
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_bullets_text' => ['nullable', 'string'],
            'location_title' => ['nullable', 'string', 'max:255'],
            'location_html' => ['nullable', 'string'],
            'google_map_embed_url' => ['nullable', 'string', 'max:2000'],
            'amenities_text' => ['nullable', 'string'],
            'gallery.*' => ['nullable', 'image', 'max:4096'],
            'pricing_html' => ['nullable', 'string'],
            'cta_primary_text' => ['nullable', 'string', 'max:80'],
            'cta_primary_url' => ['nullable', 'string', 'max:255'],
            'ideal_for_text' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ];
    }

    public function save(): void
    {
        $data = $this->validate();

        $payload = [
            'hero_title' => $data['hero_title'] ?: null,
            'hero_subtitle' => $data['hero_subtitle'] ?: null,
            'hero_bullets' => $this->linesToArray($data['hero_bullets_text'] ?? ''),
            'location_title' => $data['location_title'] ?: null,
            'location_html' => $data['location_html'] ?: null,
            'google_map_embed_url' => $data['google_map_embed_url'] ?: null,
            'amenities' => $this->linesToArray($data['amenities_text'] ?? ''),
            'pricing_html' => $data['pricing_html'] ?: null,
            'cta_primary_text' => $data['cta_primary_text'] ?: null,
            'cta_primary_url' => $data['cta_primary_url'] ?: null,
            'ideal_for' => $this->linesToArray($data['ideal_for_text'] ?? ''),
            'is_active' => $data['is_active'],
        ];

        $galleryPaths = $this->existing_gallery_images ?: [];
        foreach ($this->gallery as $image) {
            $path = $image->store('space-to-let', 'public');
            $galleryPaths[] = 'storage/' . $path;
        }
        $payload['gallery_images'] = $galleryPaths ?: null;

        $model = $this->editingId ? SpaceToLetPage::findOrFail($this->editingId) : new SpaceToLetPage();
        $model->fill($payload);
        $model->save();

        $this->editingId = $model->id;
        $this->fillFromModel($model);

        $message = 'Space to Let page updated.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Saved', message: $message);
    }

    public function removeGalleryImage(int $index): void
    {
        $images = $this->existing_gallery_images ?: [];
        if (!isset($images[$index])) return;
        unset($images[$index]);
        $this->existing_gallery_images = array_values($images);
    }

    private function fillFromModel(SpaceToLetPage $page): void
    {
        $this->hero_title = $page->hero_title;
        $this->hero_subtitle = $page->hero_subtitle;
        $this->hero_bullets_text = implode("\n", $page->hero_bullets ?? []);

        $this->location_title = $page->location_title;
        $this->location_html = $page->location_html;
        $this->google_map_embed_url = $page->google_map_embed_url;

        $this->amenities_text = implode("\n", $page->amenities ?? []);

        $this->existing_gallery_images = $page->gallery_images ?? [];
        $this->gallery = [];

        $this->pricing_html = $page->pricing_html;
        $this->cta_primary_text = $page->cta_primary_text;
        $this->cta_primary_url = $page->cta_primary_url;

        $this->ideal_for_text = implode("\n", $page->ideal_for ?? []);
        $this->is_active = (bool) $page->is_active;

        $this->dispatch('init-summernote');
    }

    private function linesToArray(string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($text));
        $lines = array_values(array_filter(array_map('trim', $lines ?: [])));
        return $lines;
    }

    public function render()
    {
        return view('livewire.admin.space-to-let-page.index');
    }
}

