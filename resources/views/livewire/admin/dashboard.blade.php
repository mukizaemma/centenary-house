@section('title', 'Hospital Dashboard')

<div>
    <!-- Simple Users-focused Dashboard -->
    <div class="row g-4">
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 h-100">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-1 text-muted text-uppercase small">Total Users</p>
                        <h4 class="mb-0 text-dark">{{ $totalUsers }}</h4>
                        <small class="text-primary">Manage users <i class="fa fa-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4 h-100">
                    <i class="fa fa-user-shield fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-1 text-muted text-uppercase small">Admin Users</p>
                        <h4 class="mb-0 text-dark">{{ $adminUsers }}</h4>
                        <small class="text-primary">View admins <i class="fa fa-arrow-right ms-1"></i></small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Welcome / Helper Text -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="bg-light rounded p-4">
                <h4 class="mb-2">Welcome to {{ config('app.name') }} Admin</h4>
                <p class="mb-0 text-muted">
                    For now this admin area is focused on user management only. Use the cards above to access the users module.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
@endpush
