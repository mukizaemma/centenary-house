<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('templates/admin/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('templates/admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('templates/admin/css/style.css') }}" rel="stylesheet">

    <!-- Centenary House brand overrides -->
    <style>
        :root {
            --primary-color: #8a1d03;
            --secondary-color: #231f20;
            --bs-primary: #8a1d03;
            --bs-primary-rgb: 138, 29, 3;
        }

        /* Buttons: primary base, secondary on hover with primary text */
        .btn-primary,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #8a1d03 !important;
            border-color: #8a1d03 !important;
            color: #ffffff !important;
        }

        .btn-primary:hover {
            background-color: #231f20 !important;
            border-color: #231f20 !important;
            color: #8a1d03 !important;
        }

        /* Sidebar and top-admin menu links: secondary by default, primary on hover/active */
        .sidebar .navbar-nav .nav-link {
            color: #231f20;
        }

        .sidebar .navbar-nav .nav-link:hover,
        .sidebar .navbar-nav .nav-link.active {
            color: #8a1d03;
            background-color: rgba(138, 29, 3, 0.06);
        }

        .sidebar .navbar-nav .nav-link i {
            color: inherit;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #231f20;
        }

        .navbar-light .navbar-nav .nav-link:hover,
        .navbar-light .navbar-nav .nav-link:focus {
            color: #8a1d03;
        }

        .text-primary {
            color: #8a1d03 !important;
        }
    </style>

    <!-- Summernote WYSIWYG for long text fields -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    
    @livewireStyles
    @stack('styles')
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>{{ config('app.name') }}</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ asset('templates/admin/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                        <span>{{ ucfirst(str_replace('_', ' ', Auth::user()->role)) }}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>

                    {{-- Hospital settings (website + headers) --}}
                    <a href="{{ route('admin.settings.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="fa fa-hospital me-2"></i>Settings
                    </a>

                    {{-- Page headers (public pages hero images) --}}
                    <a href="{{ route('admin.page-headers.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.page-headers.*') ? 'active' : '' }}">
                        <i class="fa fa-image me-2"></i>Page Headers
                    </a>

                    {{-- Homepage --}}
                    <a href="{{ route('admin.sliders.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <i class="fa fa-images me-2"></i>Home Slides
                    </a>

                    {{-- Centenary House: Services, Rooms, Enquiries, Team --}}
                    <a href="{{ route('admin.services.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="fa fa-concierge-bell me-2"></i>Services
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                        <i class="fa fa-door-open me-2"></i>Rooms
                    </a>
                    <a href="{{ route('admin.room-enquiries.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.room-enquiries.*') ? 'active' : '' }}">
                        <i class="fa fa-envelope me-2"></i>Room Enquiries
                    </a>
                    <a href="{{ route('admin.team.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                        <i class="fa fa-users me-2"></i>Team
                    </a>
                    <a href="{{ route('admin.partners.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                        <i class="fa fa-handshake me-2"></i>Trusted Partners
                    </a>

                    {{-- People --}}
                    <a href="{{ route('admin.users.index') }}" class="nav-item nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fa fa-user-md me-2"></i>
                        @if(Auth::user()->role === 'super_admin')
                            Users
                        @else
                            Staff
                        @endif
                    </a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="{{ asset('templates/admin/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <hr class="dropdown-divider">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Content Area Start -->
            <div class="container-fluid pt-4 px-4">
                {{-- Support both classic Blade (@section("content")) and Livewire 3 layouts ($slot) --}}
                @if (!empty(trim($__env->yieldContent('content'))))
                    @yield('content')
                @elseif (isset($slot))
                    {{ $slot }}
                @endif
            </div>
            <!-- Content Area End -->

            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">{{ config('app.name') }}</a>, All Right Reserved.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('templates/admin/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('templates/admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('templates/admin/js/main.js') }}"></script>

    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireScripts
    @stack('scripts')

    <script>
        (function () {
            function showFlashAlerts() {
                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: @json(session('success')),
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: @json(session('error')),
                        showConfirmButton: true
                    });
                @endif

                @if(session('status'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: @json(session('status')),
                        timer: 3000,
                        showConfirmButton: false
                    });
                @endif

                @if($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Please fix the errors',
                        html: `{!! implode('<br>', $errors->all()) !!}`
                    });
                @endif
            }

            function bootSweetAlerts() {
                showFlashAlerts();

                if (window.Livewire && typeof Livewire.on === 'function') {
                    Livewire.on('notify', (options) => {
                        const defaults = {
                            icon: options.type || 'info',
                            title: options.title || '',
                            text: options.message || '',
                            timer: 3000,
                            showConfirmButton: false
                        };
                        Swal.fire(defaults);
                    });
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bootSweetAlerts);
            } else {
                bootSweetAlerts();
            }
        })();
    </script>

    <script>
        (function () {
            function initSummernote() {
                if (!window.$ || !$.fn || !$.fn.summernote) {
                    return;
                }

                document.querySelectorAll('textarea.summernote').forEach((el) => {
                    if (el.classList.contains('is-summernote-init')) return;

                    $(el).summernote({
                        height: 220,
                        toolbar: [
                            ['style', ['bold', 'italic', 'underline', 'clear']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['insert', ['link']],
                            ['view', ['codeview']]
                        ],
                        callbacks: {
                            onChange: function (contents) {
                                el.value = contents;
                                el.dispatchEvent(new Event('input'));
                            }
                        }
                    });

                    el.classList.add('is-summernote-init');
                });
            }

            function bootSummernote() {
                initSummernote();

                if (window.Livewire) {
                    if (typeof Livewire.on === 'function') {
                        Livewire.on('init-summernote', () => initSummernote());
                    }
                    if (typeof Livewire.hook === 'function') {
                        Livewire.hook('message.processed', () => initSummernote());
                    }
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bootSummernote);
            } else {
                bootSummernote();
            }

            document.addEventListener('livewire:init', bootSummernote);
        })();
    </script>
</body>
</html>
