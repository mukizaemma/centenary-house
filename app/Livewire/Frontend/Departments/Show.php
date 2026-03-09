<?php

namespace App\Livewire\Frontend\Departments;

use App\Models\ClinicalDepartment;
use App\Models\ClinicalService;
use App\Models\Doctor;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    #[Layout('layouts.frontend')]
    public $department;

    public function mount($department)
    {
        $this->department = is_numeric($department)
            ? ClinicalDepartment::where('is_active', true)->findOrFail($department)
            : ClinicalDepartment::where('is_active', true)->where('slug', $department)->firstOrFail();
    }

    public function render()
    {
        $department = $this->department;
        $services = ClinicalService::where('clinical_department_id', $department->id)->where('is_active', true)->orderBy('sort_order')->get();
        $doctors = Doctor::where('clinical_department_id', $department->id)->where('is_active', true)->with('department')->orderBy('sort_order')->get();
        $gallery = $department->gallery ? (is_string($department->gallery) ? json_decode($department->gallery, true) : $department->gallery) : [];
        if (!is_array($gallery)) {
            $gallery = [];
        }

        return view('livewire.frontend.departments.show', [
            'department' => $department,
            'services' => $services,
            'doctors' => $doctors,
            'gallery' => $gallery,
        ]);
    }
}
