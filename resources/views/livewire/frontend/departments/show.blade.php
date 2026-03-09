<div>
<div class="content">
    <div class="department-single">
        <div class="dept-header">
            @if($department->cover_image)
                <div class="dept-cover">
                    <img src="{{ asset($department->cover_image) }}" alt="{{ $department->name }}">
                </div>
            @endif
            <h1 class="dept-title">{{ $department->name }}</h1>
            @if($department->description)
                <div class="dept-description">{!! $department->description !!}</div>
            @endif
        </div>

        @if($services->isNotEmpty())
            <section class="services-section">
                <h2 class="section-heading">Services</h2>
                <div class="services-list">
                    @foreach($services as $service)
                        <div class="service-card">
                            @if($service->cover_image)
                                <div class="service-cover">
                                    <img src="{{ asset($service->cover_image) }}" alt="{{ $service->title }}">
                                </div>
                            @endif
                            <h3>{{ $service->title }}</h3>
                            @if($service->description)
                                <div class="service-desc">{!! \Illuminate\Support\Str::limit(strip_tags($service->description), 120) !!}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        @if($doctors->isNotEmpty())
            <section class="doctors-section">
                <h2 class="section-heading">Our doctors</h2>
                <div class="team-container">
                    @foreach($doctors as $doctor)
                        <a href="{{ route('doctors.show', ['doctor' => $doctor->id, 'slug' => \Illuminate\Support\Str::slug($doctor->full_name)]) }}" class="team-container-item" wire:navigate>
                            <div class="img">
                                @if($doctor->profile_image)
                                    <img src="{{ asset($doctor->profile_image) }}" alt="{{ $doctor->full_name }}">
                                @else
                                    <div class="img-placeholder"></div>
                                @endif
                            </div>
                            <div class="team-container-item-content">
                                <h4 class="name">{{ $doctor->full_name }}</h4>
                                @if($doctor->position)
                                    <label class="title">{{ $doctor->position }}</label>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if(!empty($gallery))
            <section class="gallery-section">
                <h2 class="section-heading">Gallery</h2>
                <div class="gallery-grid">
                    @foreach($gallery as $path)
                        <a href="{{ asset($path) }}" target="_blank" rel="noopener" class="gallery-item">
                            <img src="{{ asset($path) }}" alt="">
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
<style>
.department-single { padding: 30px 0; }
.dept-cover { width: 100%; max-height: 400px; overflow: hidden; border-radius: 8px; margin-bottom: 24px; }
.dept-cover img { width: 100%; height: 100%; object-fit: cover; }
.dept-title { font-size: 1.8rem; font-weight: 600; margin-bottom: 16px; }
.dept-description { font-size: 0.95rem; line-height: 1.6; color: #555; margin-bottom: 40px; }
.services-section, .doctors-section, .gallery-section { margin: 40px 0; }
.services-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
.service-card { padding: 20px; background: #f9f9f9; border-radius: 8px; }
.service-cover { height: 160px; overflow: hidden; border-radius: 4px; margin-bottom: 12px; }
.service-cover img { width: 100%; height: 100%; object-fit: cover; }
.service-card h3 { font-size: 1rem; margin-bottom: 8px; }
.service-desc { font-size: 0.85rem; color: #666; }
.team-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
@media (max-width: 768px) { .team-container { grid-template-columns: repeat(2, 1fr); } }
.team-container-item { display: flex; flex-direction: column; align-items: center; text-align: center; text-decoration: none; color: inherit; box-shadow: 0 0 20px -2px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; padding-bottom: 16px; }
.team-container-item .img { width: 100%; aspect-ratio: 1; overflow: hidden; }
.team-container-item .img img { width: 100%; height: 100%; object-fit: cover; }
.img-placeholder { width: 100%; height: 100%; background: #f0f0f0; }
.gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
.gallery-item { display: block; border-radius: 8px; overflow: hidden; }
.gallery-item img { width: 100%; aspect-ratio: 1; object-fit: cover; }
</style>
</div>
