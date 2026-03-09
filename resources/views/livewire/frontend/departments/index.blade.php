<div>
<x-page-locator title="Our Departments" :header="$header" />
<div class="content">
    <div class="departments-list">
        <h2 class="section-heading">Read our Departments</h2>
        <p class="section-sub">We Provide Special Service For Patients</p>
        <div class="department-container">
            @foreach($departments as $department)
                <a href="{{ route('departments.show', ['department' => $department->slug ?: $department->id]) }}" class="department-container-item" wire:navigate>
                    <div class="cover">
                        @if($department->cover_image)
                            <img src="{{ asset($department->cover_image) }}" alt="{{ $department->name }}">
                        @else
                            <div class="cover-placeholder"></div>
                        @endif
                    </div>
                    <div class="item-content">
                        <h3>{{ $department->name }}</h3>
                        @if($department->description)
                            <p class="short-desc">{!! \Illuminate\Support\Str::limit(strip_tags($department->description), 80) !!}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
<style>
.departments-list { padding: 30px 0; }
.department-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
@media (max-width: 991px) { .department-container { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px) { .department-container { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .department-container { grid-template-columns: 1fr; } }
.department-container-item { display: flex; flex-direction: column; box-shadow: 0 0 20px -2px rgba(0,0,0,0.1); border-radius: 4px; overflow: hidden; text-decoration: none; color: inherit; }
.department-container-item:hover .cover img { transform: scale(1.05); }
.department-container-item .cover { height: 180px; overflow: hidden; }
.department-container-item .cover img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.cover-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #f5f5f5, #e0e0e0); }
.department-container-item .item-content { padding: 16px; }
.department-container-item .item-content h3 { font-size: 1rem; font-weight: 600; margin-bottom: 8px; }
.short-desc { font-size: 0.8rem; color: #666; line-height: 1.4; }
</style>
</div>
