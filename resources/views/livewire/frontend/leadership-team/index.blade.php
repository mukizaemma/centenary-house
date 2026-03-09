<div>
<x-page-locator title="Leadership Team" :header="$header" />
<div class="content">
    <div class="leadership-list">
        <h2 class="section-heading">Our Leadership Team</h2>
        <p class="section-sub">Meet Our Amazing Leaders</p>
        <div class="team-container">
            @foreach($members as $member)
                <a href="{{ route('leadership.show', ['member' => $member->id, 'slug' => \Illuminate\Support\Str::slug($member->full_name)]) }}" class="team-container-item" wire:navigate>
                    <div class="img">
                        @if($member->profile_image)
                            <img src="{{ asset($member->profile_image) }}" alt="{{ $member->full_name }}">
                        @else
                            <div class="img-placeholder"></div>
                        @endif
                    </div>
                    <div class="team-container-item-content">
                        <h4 class="name">{{ $member->full_name }}</h4>
                        @if($member->position)
                            <label class="title">{{ $member->position }}</label>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
<style>
.leadership-list { padding: 30px 0; }
.team-container { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
@media (max-width: 991px) { .team-container { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .team-container { grid-template-columns: 1fr; } }
.team-container-item { display: flex; flex-direction: column; align-items: center; text-align: center; text-decoration: none; color: inherit; box-shadow: 0 0 20px -2px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; padding-bottom: 16px; }
.team-container-item:hover { color: var(--primary); }
.team-container-item .img { width: 100%; aspect-ratio: 1; overflow: hidden; }
.team-container-item .img img { width: 100%; height: 100%; object-fit: cover; }
.img-placeholder { width: 100%; height: 100%; background: linear-gradient(135deg, #f5f5f5, #e0e0e0); }
.team-container-item-content .name { font-size: 1rem; font-weight: 600; margin: 8px 0 4px; }
.team-container-item-content .title { font-size: 0.8rem; color: #666; }
</style>
</div>
