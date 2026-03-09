<?php

namespace App\Livewire\Admin\Partners;

use App\Models\Partner;
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
    public string $name = '';
    public $logo;
    public ?string $logo_path = null;
    public ?string $website_url = null;
    public ?string $description = null;
    public ?string $contact_person = null;
    public ?string $contact_email = null;
    public ?string $contact_phone = null;
    public bool $is_active = true;

    protected function rules(): array
    {
        $logoRule = $this->editingId ? ['nullable', 'image', 'max:2048'] : ['required', 'image', 'max:2048'];
        return [
            'name' => ['required', 'string', 'max:255'],
            'logo' => $logoRule,
            'website_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['boolean'],
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

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    public function edit(int $id): void
    {
        $p = Partner::findOrFail($id);
        $this->editingId = $p->id;
        $this->name = $p->name;
        $this->logo_path = $p->logo_path;
        $this->logo = null;
        $this->website_url = $p->website_url ?? '';
        $this->description = $p->description ?? '';
        $this->contact_person = $p->contact_person ?? '';
        $this->contact_email = $p->contact_email ?? '';
        $this->contact_phone = $p->contact_phone ?? '';
        $this->is_active = $p->is_active;
        $this->showFormModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();
        $payload = [
            'name' => $data['name'],
            'website_url' => $data['website_url'] ?: null,
            'description' => $data['description'] ?: null,
            'contact_person' => $data['contact_person'] ?: null,
            'contact_email' => $data['contact_email'] ?: null,
            'contact_phone' => $data['contact_phone'] ?: null,
            'is_active' => $data['is_active'],
        ];
        if ($this->logo) {
            $path = $this->logo->store('partners', 'public');
            $payload['logo_path'] = 'storage/' . $path;
        }
        if ($this->editingId) {
            $model = Partner::findOrFail($this->editingId);
            $model->update($payload);
            $this->logo_path = $model->logo_path;
            $message = 'Partner updated successfully.';
        } else {
            if (empty($payload['logo_path'])) {
                $errorMessage = 'Logo is required when creating a partner.';
                session()->flash('error', $errorMessage);
                $this->dispatch('notify', type: 'error', title: 'Error', message: $errorMessage);
                return;
            }
            Partner::create($payload);
            $message = 'Partner created successfully.';
        }
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = false;
    }

    public function delete(int $id): void
    {
        Partner::findOrFail($id)->delete();
        $message = 'Partner deleted successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Deleted', message: $message);
        $this->showFormModal = false;
        $this->resetForm();
        $this->editingId = null;
    }

    protected function resetForm(): void
    {
        $this->name = '';
        $this->logo = null;
        $this->logo_path = null;
        $this->website_url = null;
        $this->description = null;
        $this->contact_person = null;
        $this->contact_email = null;
        $this->contact_phone = null;
        $this->is_active = true;
        $this->resetValidation();
    }

    public function getPartnersProperty()
    {
        return Partner::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('contact_person', 'like', '%' . $this->search . '%')
                ->orWhere('contact_email', 'like', '%' . $this->search . '%'))
            ->orderBy('name')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.partners.index', ['partners' => $this->partners]);
    }
}
