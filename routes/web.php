<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TravelController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/proyecto/{project}', [PortfolioController::class, 'showProject'])->name('portfolio.projects.show');
Route::get('/viaje/{travel}', [PortfolioController::class, 'showTravel'])->name('portfolio.travels.show');
Route::post('/contact', [PortfolioController::class, 'contact'])->name('portfolio.contact');

// Admin Auth Routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::get('/admin/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register.submit');

Route::get('/admin/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/admin/reset-password', [AuthController::class, 'resetPassword'])->name('admin.password.update');

// Admin Dashboard & Management Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Profile Info
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Biography Management
    Route::get('/biography', [DashboardController::class, 'editBiography'])->name('biography.edit');
    Route::post('/biography', [DashboardController::class, 'updateBiography'])->name('biography.update');

    // Projects CRUD
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Skills CRUD
    Route::post('/skills/update-text', [SkillController::class, 'updateText'])->name('skills.update-text');
    Route::patch('/skills/{skill}/toggle-visibility', [SkillController::class, 'toggleVisibility'])->name('skills.toggle-visibility');
    Route::resource('skills', SkillController::class)->except(['show']);

    // Travels CRUD
    Route::resource('travels', TravelController::class)->except(['show']);

    // Messages Inbox
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
});
