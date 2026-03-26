<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $websiteSettings->company_name ?? config('app.name'))</title>

    {{-- Basic SEO meta tags --}}
    <meta name="description" content="@yield('meta_description', ($websiteSettings->company_name ?? config('app.name')) . ' offers premium office and commercial spaces to let at Centenary House in Kigali, with flexible offices, retail units and modern business facilities.')">
    <meta name="keywords" content="@yield('meta_keywords', 'Centenary House, office space Kigali, offices to let Rwanda, commercial property Kigali, serviced offices, retail space Kigali, meeting rooms Kigali, business centre Rwanda')">

    {{-- Frontend stylesheet (your custom theme) --}}
    <link rel="icon" type="image/png" href="{{ ($websiteSettings->logo_path ?? null) ? asset($websiteSettings->logo_path) : asset('templates/frontend/img/favicon-homlisti.svg') }}">
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">

    @stack('styles')
    @livewireStyles
</head>
<body>
    <div class="container">
        {{-- Top bar --}}
        <div class="topheader">
            <div class="topheader-inner">
            <div class="top-left">
                @if($websiteSettings->address ?? null)
                    <span class="topheader-item">
                        <span class="topheader-item__icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </span>
                        <span class="topheader-item__text">{{ strip_tags($websiteSettings->address) }}</span>
                    </span>
                @endif
                @if($websiteSettings->phone_reception ?? $websiteSettings->phone_urgency ?? null)
                    <span class="topheader-item">
                        <span class="topheader-item__icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <a class="topheader-item__link" href="tel:{{ $websiteSettings->phone_reception ?? $websiteSettings->phone_urgency }}">{{ $websiteSettings->phone_reception ?? $websiteSettings->phone_urgency }}</a>
                    </span>
                @endif
            </div>
            <div class="top-right">
                @if($websiteSettings->email ?? null)
                    <a href="mailto:{{ $websiteSettings->email }}" aria-label="Email">
                        <svg viewBox="0 0 32 32" fill="currentColor" width="17" height="17"><path d="M30.996 7.824v17.381c0 0 0 0 0 0.001 0 1.129-0.915 2.044-2.044 2.044h-4.772v-11.587l-8.179 6.136-8.179-6.136v11.588h-4.772c-1.129 0-2.044-0.915-2.044-2.044V7.824c0-1.694 1.373-3.067 3.067-3.067 0.694 0 1.334 0.231 1.848 0.619l10.088 7.567 10.088-7.567c0.506-0.383 1.146-0.613 1.84-0.613 1.694 0 3.067 1.373 3.067 3.067v0z"/></svg>
                    </a>
                @endif
                @if($websiteSettings->facebook_url ?? null)
                    <a href="{{ $websiteSettings->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                @endif
                @if($websiteSettings->instagram_url ?? null)
                    <a href="{{ $websiteSettings->instagram_url }}" target="_blank" rel="noopener" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
                @if($websiteSettings->linkedin_url ?? null)
                    <a href="{{ $websiteSettings->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                @endif
                @if($websiteSettings->youtube_url ?? null)
                    <a href="{{ $websiteSettings->youtube_url }}" target="_blank" rel="noopener" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                @endif
                @if($websiteSettings->x_url ?? null)
                    <a href="{{ $websiteSettings->x_url }}" target="_blank" rel="noopener" aria-label="X (Twitter)">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                @endif
                @if($websiteSettings->threads_url ?? null)
                    <a href="{{ $websiteSettings->threads_url }}" target="_blank" rel="noopener" aria-label="Threads">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17"><path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 7.792 3.616 9.597 3.442 11.994v.014c.174 2.397.865 4.203 2.293 5.984 1.43 1.782 3.631 2.698 6.541 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.2-1.634-1.443-.192-.06-.4-.092-.613-.092-1.338 0-2.386 1.085-2.386 2.386 0 .67.274 1.31.755 1.768.466.443 1.1.687 1.78.687.384 0 .754-.078 1.1-.226 2.238-.963 3.637-3.106 3.637-5.55 0-2.336-1.102-4.377-2.834-5.63-1.72-1.245-3.917-1.868-6.4-1.868-2.483 0-4.68.623-6.4 1.868-1.732 1.253-2.834 3.294-2.834 5.63 0 2.444 1.399 4.587 3.637 5.55.346.148.716.226 1.1.226.68 0 1.314-.244 1.78-.687.481-.458.755-1.098.755-1.768 0-1.301-1.048-2.386-2.386-2.386-.213 0-.421.032-.613.092-.761.243-1.324.733-1.634 1.443-.528 1.205-.557 3.185 1.09 4.798 1.442 1.414 3.177 2.025 5.8 2.045 3.406-.031 6.2-2.055 8.304-6.015l2.04.569c-.651 2.337-1.832 4.177-3.509 5.467-1.783 1.373-4.08 2.078-6.826 2.098z"/></svg>
                    </a>
                @endif
            </div>
            </div>
        </div>

        {{-- Navbar --}}
        <nav class="navbar">
            <a href="{{ route('home') }}" class="navbar-logo" wire:navigate>
                @if($websiteSettings->logo_path ?? null)
                    <img src="{{ asset($websiteSettings->logo_path) }}" alt="{{ $websiteSettings->company_name ?? 'Logo' }}">
                @else
                    <span style="font-weight:700;color:var(--primary);">{{ $websiteSettings->company_name ?? config('app.name') }}</span>
                @endif
            </a>

            <div class="navbar-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" wire:navigate>Home</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" wire:navigate>About</a>
                <a href="{{ route('public.services') }}" class="nav-link {{ request()->routeIs('public.services') ? 'active' : '' }}" wire:navigate>Our Services</a>
                <a href="{{ route('space-to-let') }}" class="nav-link {{ request()->routeIs('space-to-let') ? 'active' : '' }}" wire:navigate>Space to Let</a>
                <a href="{{ route('updates') }}" class="nav-link {{ request()->routeIs('updates') ? 'active' : '' }}" wire:navigate>Updates</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" wire:navigate>Contact</a>
            </div>

            <div class="navbar-right">
                <a href="{{ route('login') }}" class="nav-link nav-link-login {{ request()->routeIs('login') ? 'active' : '' }}" wire:navigate>
                    Login
                </a>
            </div>
        </nav>

        {{-- Main content (Livewire slot) --}}
        <main class="main-content">
            {{ $slot ?? '' }}
        </main>

        {{-- Trusted partners strip (above footer on every page) --}}
        <livewire:frontend.partners-strip />

        {{-- Footer --}}
        <footer class="footer">
            <div class="footer-grid">
                <div class="footer-logo">
                    <a href="{{ route('home') }}" wire:navigate class="footer-logo-link">
                        @if($websiteSettings->logo_path ?? null)
                            <img src="{{ asset($websiteSettings->logo_path) }}" alt="{{ $websiteSettings->company_name ?? config('app.name') }}" class="footer-logo-img">
                        @else
                            <span class="footer-logo-text">{{ $websiteSettings->company_name ?? config('app.name') }}</span>
                        @endif
                    </a>
                    @if($websiteSettings->home_quote ?? null)
                        <div class="footer-quote">
                            {!! $websiteSettings->home_quote !!}
                        </div>
                    @endif
                </div>
                <div class="footer-links">
                    <h3>Quick links</h3>
                    <a href="{{ route('home') }}" wire:navigate>Home</a>
                    <a href="{{ route('about') }}" wire:navigate>About</a>
                    <a href="{{ route('public.services') }}" wire:navigate>Our Services</a>
                    <a href="{{ route('space-to-let') }}" wire:navigate>Space to Let</a>
                    <a href="{{ route('updates') }}" wire:navigate>Updates</a>
                    <a href="{{ route('contact') }}" wire:navigate>Contact</a>
                </div>
                <div class="footer-contacts-wrap">
                    <h3>Contact</h3>
                    <div class="footer-contacts">
                        @if($websiteSettings->address ?? null)
                            <div class="footer-contact-item">
                                <span class="footer-contact-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </span>
                                <span>{{ strip_tags($websiteSettings->address) }}</span>
                            </div>
                        @endif
                        @if($websiteSettings->phone_reception ?? $websiteSettings->phone_urgency ?? null)
                            <div class="footer-contact-item">
                                <span class="footer-contact-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </span>
                                <a href="tel:{{ $websiteSettings->phone_reception ?? $websiteSettings->phone_urgency }}">{{ $websiteSettings->phone_reception ?? $websiteSettings->phone_urgency }}</a>
                            </div>
                        @endif
                        @if($websiteSettings->email ?? null)
                            <div class="footer-contact-item">
                                <span class="footer-contact-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </span>
                                <a href="mailto:{{ $websiteSettings->email }}">{{ $websiteSettings->email }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="copyright-and-credits">
                    <span class="copyright">
                        Copyright © {{ date('Y') }} {{ $websiteSettings->company_name ?? config('app.name') }}. All rights reserved.
                    </span>
                    <span class="footer-credits">
                        Delivered by <a href="https://iremetech.com" target="_blank" rel="noopener noreferrer">Ireme Technologies</a>
                    </span>
                </div>
            </div>
        </footer>

        {{-- Floating \"Book Your Space\" button (left middle) --}}
        <a href="{{ route('space-to-let') }}" wire:navigate class="book-space-float" aria-label="Book your space">
            <span>Book Your Space</span>
        </a>

        {{-- Floating WhatsApp icon (left lower side) --}}
        @if($websiteSettings->phone_reception ?? null)
            @php
                $waNumber = preg_replace('/[^0-9]/', '', $websiteSettings->phone_reception);
            @endphp
            @if($waNumber)
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="whatsapp-float" aria-label="Chat on WhatsApp">
                    <svg viewBox="0 0 32 32" fill="currentColor" width="28" height="28" aria-hidden="true">
                        <path d="M16 0C7.164 0 0 7.164 0 16c0 2.825.736 5.48 2.024 7.784L.056 31.68l8.064-2.112A15.92 15.92 0 0016 32c8.836 0 16-7.164 16-16S24.836 0 16 0zm0 29.333c-2.616 0-5.084-.696-7.22-1.912l-.508-.3-5.264 1.38 1.408-5.14-.332-.528A13.22 13.22 0 012.667 16c0-7.364 5.969-13.333 13.333-13.333S29.333 8.636 29.333 16 23.364 29.333 16 29.333zm7.316-9.964c-.392-.196-2.316-1.144-2.676-1.272-.36-.128-.624-.196-.888.196-.264.392-1.024 1.272-1.256 1.532-.232.26-.464.292-.856.096-.392-.196-1.656-.612-3.156-1.948-1.168-1.04-1.952-2.324-2.18-2.716-.228-.392-.024-.604.172-.796.176-.176.392-.46.588-.688.196-.228.26-.392.392-.656.132-.264.066-.492-.032-.688-.1-.196-.888-2.14-1.216-2.928-.324-.776-.656-.672-.888-.684l-.756-.016c-.264 0-.688.096-1.048.476-.36.38-1.376 1.344-1.376 3.276 0 1.932 1.408 3.036 1.604 3.244.196.208 2.776 4.244 6.724 5.828.936.376 1.668.6 2.236.768.936.272 1.788.232 2.46.14.752-.104 2.316-.948 2.64-1.86.324-.912.324-1.692.228-1.86-.096-.168-.36-.264-.752-.46z"/>
                    </svg>
                </a>
            @endif
        @endif
    </div>

    {{-- SweetAlert2 for global notifications --}}
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
                        timer: 4000,
                        showConfirmButton: false
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: @json(session('error')),
                        timer: 5000,
                        showConfirmButton: true
                    });
                @endif

                @if(session('contact_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Message sent',
                        text: @json(session('contact_success')),
                        timer: 4000,
                        showConfirmButton: false
                    });
                @endif

                @if(session('feedback_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Feedback received',
                        text: @json(session('feedback_success')),
                        timer: 4000,
                        showConfirmButton: false
                    });
                @endif

                @if(session('service_request_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Request sent',
                        text: @json(session('service_request_success')),
                        timer: 4000,
                        showConfirmButton: false
                    });
                @endif

                @if(session('office_enquiry_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Enquiry sent',
                        text: @json(session('office_enquiry_success')),
                        timer: 4000,
                        showConfirmButton: false
                    });
                @endif

                @if(session('space_to_let_enquiry_success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Enquiry sent',
                        text: @json(session('space_to_let_enquiry_success')),
                        timer: 4000,
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
                            timer: 4000,
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
        // Scroll reveal for headings and cards on public pages
        (function () {
            let observer;

            function getRevealElements() {
                const selectors = [
                    '.content h1',
                    '.content h2',
                    '.content h3',
                    '.locator-title',
                    '.section-header',
                    '.section-heading',
                    '.section-sub',
                    '.service-card',
                    '.space-card',
                    '.room-detail__title',
                    '.room-detail__media',
                    '.room-detail__description',
                    '.service-detail__title',
                    '.service-detail__body--full',
                    '.service-detail__card',
                    '.home-cta-contact-enquiry__inner',
                    '.office-enquiry',
                    '.contact-page__aside',
                    '.contact-page__form-wrap .space-enquiry',
                    '.contact-page__map',
                    '.feedback-page',
                    '.services-grid .service-card',
                    '.gallery-card',
                    '.updates-list > article'
                ];

                return document.querySelectorAll(selectors.join(','));
            }

            function ensureObserver() {
                if (observer) return observer;

                if (!('IntersectionObserver' in window)) {
                    // Fallback: show all immediately
                    getRevealElements().forEach((el) => {
                        el.classList.add('reveal-on-scroll', 'is-visible');
                    });
                    return null;
                }

                observer = new IntersectionObserver(
                    (entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('is-visible');
                                observer.unobserve(entry.target);
                            }
                        });
                    },
                    {
                        threshold: 0.15,
                        rootMargin: '0px 0px -10% 0px',
                    }
                );

                return observer;
            }

            function initScrollReveal() {
                const obs = ensureObserver();
                const elements = getRevealElements();

                elements.forEach((el) => {
                    if (el.classList.contains('reveal-on-scroll-initialized')) return;
                    el.classList.add('reveal-on-scroll', 'reveal-on-scroll-initialized');
                    if (obs) {
                        obs.observe(el);
                    }

                    // If element is already in viewport, show it immediately
                    const rect = el.getBoundingClientRect();
                    const vh = window.innerHeight || document.documentElement.clientHeight;
                    if (rect.top < vh * 0.9) {
                        // Use RAF so transition still plays
                        requestAnimationFrame(() => {
                            el.classList.add('is-visible');
                        });
                    }
                });
            }

            function bootScrollReveal() {
                initScrollReveal();

                if (window.Livewire) {
                    if (typeof Livewire.hook === 'function') {
                        Livewire.hook('message.processed', () => {
                            initScrollReveal();
                        });
                    }
                    if (typeof Livewire.on === 'function') {
                        Livewire.on('refresh-scroll-reveal', () => {
                            initScrollReveal();
                        });
                    }
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', bootScrollReveal);
            } else {
                bootScrollReveal();
            }

            document.addEventListener('livewire:init', bootScrollReveal);
        })();
    </script>
</body>
</html>
