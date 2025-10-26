<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Admin Controllers ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
// Note: The Google and OTP controllers are for the web interface, not the admin panel.
// We can leave them here if you plan to have a web login page as well.
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\NotificationController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public homepage
Route::get('/', function () {
    return view('welcome');
});

// === Admin Dashboard Routes ===
// All routes in this group will be prefixed with /admin (e.g., /admin/dashboard)
// and protected by 'auth' and 'is.admin' middleware.
Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // The main dashboard page, now points to the correct controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes for managing articles and users
    Route::resource('articles', ArticleController::class)->parameters([
    'articles' => 'article:slug'
]);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    // Additional custom routes
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/all', [NotificationController::class, 'history'])->name('notifications.history');
});


// All authentication routes (login, register, forgot password, etc.)
// This file also includes the default user /dashboard route.
require __DIR__.'/auth.php';