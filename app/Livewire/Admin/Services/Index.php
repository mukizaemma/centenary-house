<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
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
    public string $title = '';
    public ?string $description = null;
    public $cover_image;
    public ?string $cover_image_path = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'cover_image' => [$this->editingId ? 'nullable' : 'nullable', 'image', 'max:4096'],
            'is_active' => ['boolean'],
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
        $this->showFormModal = true;
        $this->dispatch('init-summernote');
    }

    public function edit(int $id): void
    {
        $s = Service::findOrFail($id);
        $this->editingId = $s->id;
        $this->title = $s->title;
        $this->description = $s->description ?? '';
        $this->cover_image_path = $s->cover_image;
        $this->cover_image = null;
        $this->is_active = $s->is_active;
        $this->sort_order = $s->sort_order;
        $this->showFormModal = true;
        $this->dispatch('init-summernote');
    }

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    public function save(): void
    {
        $data = $this->validate();
        $payload = [
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'description' => $data['description'] ?: null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];
        if ($this->cover_image) {
            $path = $this->cover_image->store('services', 'public');
            $payload['cover_image'] = 'storage/' . $path;
        }
        if ($this->editingId) {
            $model = Service::findOrFail($this->editingId);
            $model->update($payload);
            $message = 'Service updated successfully.';
        } else {
            Service::create($payload);
            $message = 'Service created successfully.';
        }
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
        $message = 'Service deleted successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Deleted', message: $message);
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function resetForm(): void
    {
        $this->title = '';
        $this->description = null;
        $this->cover_image = null;
        $this->cover_image_path = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getServicesProperty()
    {
        return Service::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.services.index', [
            'services' => $this->services,
        ]);
    }
}
