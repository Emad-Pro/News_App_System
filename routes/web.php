<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Admin Controllers ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\TribeHistoryController;
// Required for the localization package
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| All web routes are now wrapped in the localization group to support
| multilingual URLs like /ar/dashboard and /en/dashboard.
|
*/

Route::group(
     [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [
            'localeSessionRedirect',
            'localizationRedirect',
            'localeViewPath'
        ]
    ], function() {

    /** All translatable routes go here **/

    // Public homepage
    Route::get('/', function () {
        return view('admin/welcome');
    });

    // === Admin Dashboard Routes ===
    // All routes in this group will be prefixed with /admin and protected
    Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // The main dashboard page
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Resource routes for managing content
        Route::resource('articles', ArticleController::class)->parameters(['articles' => 'article:slug']);
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('histories', TribeHistoryController::class);

        // Custom action routes
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::post('/articles/{article}/toggle-comments', [ArticleController::class, 'toggleComments'])->name('articles.toggleComments');

        // Notification routes
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::get('/notifications/all', [NotificationController::class, 'history'])->name('notifications.history');
    });

    // All authentication routes (login, register, forgot password, etc.)
    require __DIR__.'/auth.php';
});