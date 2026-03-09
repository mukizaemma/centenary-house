<?php

namespace App\Livewire\Admin\Team;

use App\Models\TeamMember;
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
    public string $full_name = '';
    public string $position = '';
    public $photo;
    public ?string $photo_path = null;
    public ?string $biography = null;
    public ?string $email = null;
    public ?string $phone = null;
    public bool $is_active = true;
    public ?int $sort_order = null;

    protected function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'photo' => [$this->editingId ? 'nullable' : 'nullable', 'image', 'max:4096'],
            'biography' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
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
        $m = TeamMember::findOrFail($id);
        $this->editingId = $m->id;
        $this->full_name = $m->full_name;
        $this->position = $m->position;
        $this->photo_path = $m->photo_path;
        $this->photo = null;
        $this->biography = $m->biography ?? '';
        $this->email = $m->email ?? '';
        $this->phone = $m->phone ?? '';
        $this->is_active = $m->is_active;
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
            'full_name' => $data['full_name'],
            'position' => $data['position'],
            'biography' => $data['biography'] ?: null,
            'email' => $data['email'] ?: null,
            'phone' => $data['phone'] ?: null,
            'is_active' => $data['is_active'],
            'sort_order' => $data['sort_order'] ?? null,
        ];
        if ($this->photo) {
            $path = $this->photo->store('team', 'public');
            $payload['photo_path'] = 'storage/' . $path;
        }
        if ($this->editingId) {
            $model = TeamMember::findOrFail($this->editingId);
            $model->update($payload);
            $message = 'Team member updated successfully.';
        } else {
            TeamMember::create($payload);
            $message = 'Team member created successfully.';
        }
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        TeamMember::findOrFail($id)->delete();
        $message = 'Team member deleted successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Deleted', message: $message);
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function resetForm(): void
    {
        $this->full_name = '';
        $this->position = '';
        $this->photo = null;
        $this->photo_path = null;
        $this->biography = null;
        $this->email = null;
        $this->phone = null;
        $this->is_active = true;
        $this->sort_order = null;
        $this->resetValidation();
    }

    public function getTeamMembersProperty()
    {
        return TeamMember::query()
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('position', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('sort_order')
            ->orderBy('full_name')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.team.index', [
            'teamMembers' => $this->teamMembers,
        ]);
    }
}
