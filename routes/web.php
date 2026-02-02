<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', function () {
        return Inertia::render('Profile/MyProfile');
    })->name('my-profile');

    Route::get('/security', function () {
        return Inertia::render('Profile/Security');
    })->name('security');

    Route::get('/team/overview', function () {
        $user = auth()->user();
        // Only admin (owner) can access full team overview
        if ($user->role !== 'admin') {
            return redirect()->route('dashboard');
        }
        return Inertia::render('Team/Overview');
    })->name('team.overview');

    Route::get('/support/service-desk', function () {
        return Inertia::render('Support/ServiceDesk');
    })->name('service-desk');

    // Pre-Sales Routes
    Route::get('/pre-sales/survey', function () {
        return Inertia::render('PreSales/Survey');
    })->name('pre-sales.survey');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-based Dashboards
    Route::prefix('dashboard')->group(function () {
        Route::get('/executive', [DashboardController::class, 'executive'])->name('dashboard.executive');
        Route::get('/team-leader', [DashboardController::class, 'teamLeader'])->name('dashboard.team-leader');
        Route::get('/geo-head', [DashboardController::class, 'geoHead'])->name('dashboard.geo-head');
        Route::get('/vp', [DashboardController::class, 'vicePresident'])->name('dashboard.vp');
        Route::get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::get('/hr', [DashboardController::class, 'hr'])->name('dashboard.hr');
    });
});

require __DIR__.'/auth.php';
