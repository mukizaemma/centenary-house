<?php

namespace App\Livewire\Admin\SpaceTestimonials;

use App\Models\SpaceTestimonial;
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

    public string $quote = '';
    public ?string $name = null;
    public ?string $role = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    protected function rules(): array
    {
        return [
            'quote' => ['required', 'string', 'min:10'],
            'name' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
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
    }

    public function edit(int $id): void
    {
        $t = SpaceTestimonial::findOrFail($id);
        $this->editingId = $t->id;
        $this->quote = $t->quote;
        $this->name = $t->name ?? '';
        $this->role = $t->role ?? '';
        $this->is_active = (bool) $t->is_active;
        $this->sort_order = $t->sort_order;
        $this->showFormModal = true;
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
            'quote' => $data['quote'],
            'name' => $data['name'] ?: null,
            'role' => $data['role'] ?: null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? 0,
        ];

        if ($this->editingId) {
            SpaceTestimonial::findOrFail($this->editingId)->update($payload);
            $message = 'Testimonial updated successfully.';
        } else {
            SpaceTestimonial::create($payload);
            $message = 'Testimonial created successfully.';
        }

        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
        $this->closeFormModal();
    }

    public function delete(int $id): void
    {
        SpaceTestimonial::findOrFail($id)->delete();
        $message = 'Testimonial deleted successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Deleted', message: $message);
    }

    protected function resetForm(): void
    {
        $this->quote = '';
        $this->name = null;
        $this->role = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getTestimonialsProperty()
    {
        return SpaceTestimonial::query()
            ->when($this->search, fn($q) => $q->where('quote', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%')
                ->orWhere('role', 'like', '%' . $this->search . '%'))
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.space-testimonials.index', [
            'testimonials' => $this->testimonials,
        ]);
    }
}

