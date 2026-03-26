<?php

namespace App\Livewire\Admin\SpaceTypes;

use App\Models\SpaceType;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editingId = null;
    public bool $showFormModal = false;

    public string $title = '';
    public ?string $starting_price = null;
    public ?string $description = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'starting_price' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
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
        $m = SpaceType::findOrFail($id);
        $this->editingId = $m->id;
        $this->title = $m->title;
        $this->starting_price = $m->starting_price;
        $this->description = $m->description ?? '';
        $this->is_active = (bool) $m->is_active;
        $this->sort_order = $m->sort_order;
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
            'starting_price' => $data['starting_price'] ?: null,
            'description' => $data['description'] ?: null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? 0,
        ];

        if ($this->editingId) {
            SpaceType::findOrFail($this->editingId)->update($payload);
            $message = 'Space type updated successfully.';
        } else {
            SpaceType::create($payload);
            $message = 'Space type created successfully.';
        }

        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
        $this->closeFormModal();
    }

    public function delete(int $id): void
    {
        SpaceType::findOrFail($id)->delete();
        $message = 'Space type deleted successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Deleted', message: $message);
    }

    protected function resetForm(): void
    {
        $this->title = '';
        $this->starting_price = null;
        $this->description = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getSpaceTypesProperty()
    {
        return SpaceType::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.space-types.index', [
            'spaceTypes' => $this->spaceTypes,
        ]);
    }
}

