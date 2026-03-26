<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public frontend SPA (Livewire-powered)
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', \App\Livewire\Frontend\Home::class)->name('home');
Route::get('/about', \App\Livewire\Frontend\About::class)->name('about');
Route::get('/services', \App\Livewire\Frontend\Services::class)->name('public.services');
Route::get('/services/{service:slug}', \App\Livewire\Frontend\ServiceShow::class)->name('public.services.show');
Route::get('/space-to-let', \App\Livewire\Frontend\Spaces::class)->name('space-to-let');
Route::get('/space-to-let/{room:slug}', \App\Livewire\Frontend\RoomShow::class)->name('space-to-let.show');
Route::get('/updates', \App\Livewire\Frontend\Updates::class)->name('updates');
Route::get('/contact', \App\Livewire\Frontend\Contact::class)->name('contact');
Route::get('/partners', \App\Livewire\Frontend\Partners\Index::class)->name('partners.index');
Route::get('/partners/{partner}', \App\Livewire\Frontend\Partners\Show::class)->name('partners.show');

// Public Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
});

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', \App\Livewire\Admin\Auth\Login::class)->name('login');
        Route::get('/password/forgot', \App\Livewire\Admin\Auth\ForgotPassword::class)->name('password.request');
        Route::get('/password/reset/{token}', \App\Livewire\Admin\Auth\ResetPassword::class)->name('password.reset');
    });

    // Admin Dashboard, Settings & Users Routes (requires authentication and admin role)
    Route::middleware(['auth', 'role:super_admin,website_admin'])->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
        Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings.index');
        Route::get('/page-headers', \App\Livewire\Admin\PageHeaders\Index::class)->name('page-headers.index');
        // Users & staff management
        Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('users.index');
        // Home slider images
        Route::get('/sliders', \App\Livewire\Admin\Sliders\Index::class)->name('sliders.index');
        // Centenary House: Services, Rooms, Enquiries, Team
        Route::get('/services', \App\Livewire\Admin\Services\Index::class)->name('services.index');
        Route::get('/rooms', \App\Livewire\Admin\Rooms\Index::class)->name('rooms.index');
        Route::get('/room-enquiries', \App\Livewire\Admin\RoomEnquiries\Index::class)->name('room-enquiries.index');
        Route::get('/team', \App\Livewire\Admin\Team\Index::class)->name('team.index');
        Route::get('/partners', \App\Livewire\Admin\Partners\Index::class)->name('partners.index');
    });
});

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');
