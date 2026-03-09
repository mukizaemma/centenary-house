<?php

namespace App\Livewire\Admin\Rooms;

use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';
    public ?int $editingId = null;
    public bool $showFormModal = false;
    public bool $showGalleryModal = false;
    public ?int $galleryRoomId = null;

    public string $title = '';
    public ?string $floor = null;
    public $square_meters = null;
    public $amount = null;
    public $amount_per_sqm = null;
    public ?string $description = null;
    public $cover_image;
    public ?string $cover_image_path = null;
    public bool $is_available = true;
    public ?int $sort_order = null;

    /** Gallery: new images to add */
    public array $gallery_images = [];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'square_meters' => ['nullable', 'numeric', 'min:0'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'amount_per_sqm' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'cover_image' => [$this->editingId ? 'nullable' : 'nullable', 'image', 'max:4096'],
            'is_available' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->galleryRoomId = null;
        $this->showFormModal = true;
        $this->showGalleryModal = false;
        $this->dispatch('init-summernote');
    }

    public function edit(int $id): void
    {
        $r = Room::findOrFail($id);
        $this->editingId = $r->id;
        $this->title = $r->title;
        $this->floor = $r->floor;
        $this->square_meters = $r->square_meters;
        $this->amount = $r->amount;
        $this->amount_per_sqm = $r->amount_per_sqm;
        $this->description = $r->description ?? '';
        $this->cover_image_path = $r->cover_image_path;
        $this->cover_image = null;
        $this->is_available = $r->is_available;
        $this->sort_order = $r->sort_order;
        $this->galleryRoomId = null;
        $this->showFormModal = true;
        $this->showGalleryModal = false;
        $this->dispatch('init-summernote');
    }

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
        $this->showGalleryModal = false;
        $this->resetForm();
        $this->editingId = null;
        $this->galleryRoomId = null;
    }

    public function save(): void
    {
        $data = $this->validate();
        $payload = [
            'title' => $data['title'],
            'floor' => $this->floor ?: null,
            'slug' => Str::slug($data['title']),
            'square_meters' => $data['square_meters'] ?? null,
            'description' => $data['description'] ?: null,
            'is_available' => $data['is_available'],
            'sort_order' => $data['sort_order'] ?? null,
        ];

        // Pricing logic: per sqm or custom monthly amount
        $square = $data['square_meters'] ?? null;
        $perSqm = $data['amount_per_sqm'] ?? null;
        $custom = $data['amount'] ?? null;

        if ($square !== null && $perSqm !== null) {
            $payload['amount_per_sqm'] = $perSqm;
            $payload['amount'] = $square * $perSqm;
        } else {
            $payload['amount_per_sqm'] = null;
            $payload['amount'] = $custom ?? null;
        }
        if ($this->cover_image) {
            $path = $this->cover_image->store('rooms', 'public');
            $payload['cover_image_path'] = 'storage/' . $path;
        }
        if ($this->editingId) {
            $model = Room::findOrFail($this->editingId);
            $slug = Str::slug($data['title']);
            if (Room::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                $slug = $slug . '-' . $model->id;
            }
            $payload['slug'] = $slug;
            $model->update($payload);
            $message = 'Room updated successfully.';
        } else {
            $slug = Str::slug($data['title']);
            if (Room::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . now()->timestamp;
            }
            $payload['slug'] = $slug;
            Room::create($payload);
            $message = 'Room created successfully.';
        }
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        Room::findOrFail($id)->delete();
        $message = 'Room deleted successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Deleted', message: $message);
        $this->showFormModal = false;
        $this->showGalleryModal = false;
        $this->galleryRoomId = null;
        $this->resetForm();
        $this->editingId = null;
    }

    public function openGalleryModal(int $roomId): void
    {
        $this->galleryRoomId = $roomId;
        $this->gallery_images = [];
        $this->showGalleryModal = true;
    }

    public function closeGalleryModal(): void
    {
        $this->showGalleryModal = false;
        $this->galleryRoomId = null;
        $this->gallery_images = [];
    }

    public function addGalleryImages(): void
    {
        $files = is_array($this->gallery_images) ? $this->gallery_images : array_filter([$this->gallery_images]);
        $this->gallery_images = $files;

        $this->validate([
            'gallery_images' => ['required', 'array', 'min:1'],
            'gallery_images.*' => ['required', 'image', 'max:4096'],
        ]);

        $room = Room::findOrFail($this->galleryRoomId);
        $maxOrder = $room->images()->max('sort_order') ?? 0;
        $added = 0;
        foreach ($this->gallery_images as $file) {
            if (is_object($file) && method_exists($file, 'store')) {
                $path = $file->store('rooms/gallery', 'public');
                $room->images()->create([
                    'image_path' => 'storage/' . $path,
                    'sort_order' => $maxOrder + 1 + $added,
                ]);
                $added++;
            }
        }
        $this->gallery_images = [];
        $message = $added . ' image(s) added to gallery.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Gallery updated', message: $message);
    }

    public function removeGalleryImage(int $imageId): void
    {
        RoomImage::where('room_id', $this->galleryRoomId)->where('id', $imageId)->delete();
        $message = 'Image removed from gallery.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Gallery updated', message: $message);
    }

    protected function resetForm(): void
    {
        $this->title = '';
        $this->floor = null;
        $this->square_meters = null;
        $this->amount = null;
        $this->amount_per_sqm = null;
        $this->description = null;
        $this->cover_image = null;
        $this->cover_image_path = null;
        $this->is_available = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getRoomsProperty()
    {
        return Room::query()
            ->withCount('images')
            ->when($this->search, fn ($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10);
    }

    public function getGalleryRoomProperty(): ?Room
    {
        if (!$this->galleryRoomId) {
            return null;
        }
        return Room::with('images')->find($this->galleryRoomId);
    }

    public function render()
    {
        return view('livewire.admin.rooms.index', [
            'rooms' => $this->rooms,
            'galleryRoom' => $this->galleryRoom,
        ]);
    }
}
