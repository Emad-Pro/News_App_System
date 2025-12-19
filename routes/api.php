<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
// Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ArticleController;   // ✅ المسؤول عن المقالات واللايكات
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\UserArticleVideoController;

/*
|--------------------------------------------------------------------------
| Public Routes (لا تحتاج تسجيل دخول)
|--------------------------------------------------------------------------
*/

// Authentication
Route::post('/register', [AuthController::class, 'registerWithEmail']);
Route::post('/login', [AuthController::class, 'loginWithEmail']);
Route::post('/register-phone', [AuthController::class, 'registerWithPhone']);
Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);
Route::post('/auth/google', [AuthController::class, 'authWithGoogle']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);

// Articles (Read Only)
Route::get('/articles', [ArticleController::class, 'index']); // عرض الكل مع البحث والفلتر
Route::get('/articles/{article:slug}', [ArticleController::class, 'show']); // عرض مقال واحد بالـ Slug
Route::get('/articles/{article:slug}/comments', [CommentController::class, 'index']); // عرض التعليقات

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category:slug}/articles', [CategoryController::class, 'articles']);

// History & Videos (Public Data)
Route::get('/history', [HistoryController::class, 'index']);
Route::get('/admin-videos', [UserArticleVideoController::class, 'index']);

// Users List (Public - Be careful with this in production)
Route::get('/users', function () {
    return response()->json(User::all());
});

/*
|--------------------------------------------------------------------------
| Protected Routes (يجب إرسال Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // User Data
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile/update', [ProfileController::class, 'update']);

    // ✅ Like System (Updated to use ArticleController)
    // لاحظ: استخدمنا {article:slug} لكي يتوافق مع باقي الروابط لديك، 
    // ولكن يمكنك استخدام {article} فقط إذا كنت ترسل الـ ID من التطبيق
    Route::post('/articles/{article:slug}/like', [ArticleController::class, 'toggleLike']);

    // Comments Actions
    Route::post('/articles/{article:slug}/comments', [CommentController::class, 'store']);
});