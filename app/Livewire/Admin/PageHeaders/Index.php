<?php

namespace App\Livewire\Admin\PageHeaders;

use App\Models\PageHeader;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithFileUploads;

    public string $page_key = 'contact';
    public ?string $title = null;
    public ?string $caption = null;
    public $image = null;
    public ?string $image_path = null;

    protected array $pageOptions = [
        'about' => 'About',
        'services' => 'Services',
        'space-to-let' => 'Space to Let',
        'book-tour' => 'Book a tour visit',
        'updates' => 'Updates',
        'contact' => 'Contact',
        // Legacy / optional pages
        'departments' => 'Departments',
        'doctors' => 'Doctors',
        'gallery' => 'Gallery',
        'feedback' => 'Feedback',
        'leadership' => 'Leadership Team',
        'appointment' => 'Appointment',
    ];

    public function mount(): void
    {
        $this->loadHeader();
    }

    public function updatedPageKey(): void
    {
        $this->loadHeader();
    }

    protected function loadHeader(): void
    {
        $header = PageHeader::where('page_key', $this->page_key)->first();

        $this->title = $header?->title;
        $this->caption = $header?->caption;
        $this->image_path = $header?->image_path;
        $this->image = null;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'page_key' => ['required', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $header = PageHeader::updateOrCreate(
            ['page_key' => $validated['page_key']],
            [
                'title' => $this->title,
                'caption' => $this->caption,
            ]
        );

        if ($this->image) {
            $path = $this->image->store('page-headers', 'public');
            $header->image_path = 'storage/' . $path;
            $header->save();
            $this->image_path = $header->image_path;
            $this->image = null;
        }

        $message = 'Page header saved successfully.';
        session()->flash('success', $message);
        $this->dispatch('notify', type: 'success', title: 'Success', message: $message);
    }

    public function render()
    {
        return view('livewire.admin.page-headers.index', [
            'pageOptions' => $this->pageOptions,
        ]);
    }
}

