<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User; // لا تنسى إضافة هذا السطر لاستخدام موديل المستخدم
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ArticleController;   // <-- السطر الأهم لحل مشكلتك
use App\Http\Controllers\Api\CategoryController; // <-- وهذا أيضًا
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController; // <-- أضف هذا

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// هذا هو المسار الذي يأتي كمثال مع Sanctum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'registerWithEmail']);
Route::post('/login', [AuthController::class, 'loginWithEmail']);
Route::post('/register-phone', [AuthController::class, 'registerWithPhone']);
Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);
Route::post('/auth/google', [AuthController::class, 'authWithGoogle']);
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
Route::get('/articles/{article:slug}/comments', [CommentController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/articles/{article:slug}/like', [LikeController::class, 'toggleLike']);
    
    
});
Route::middleware('auth:sanctum')->post('/articles/{article:slug}/comments', [CommentController::class, 'store']);
Route::get('/articles', [ArticleController::class, 'index']); // جلب كل المقالات (مع الفرز والبحث)
Route::get('/articles/{article:slug}', [ArticleController::class, 'show']); // جلب مقال واحد عن طريق الـ slug

// == Category Routes ==
Route::get('/categories', [CategoryController::class, 'index']); // جلب كل الفئات
Route::get('/categories/{category:slug}/articles', [CategoryController::class, 'articles']); // جلب مقالات فئة معينة
Route::get('/users', function () {
    // جلب كل المستخدمين من قاعدة البيانات وإرجاعهم بصيغة JSON
    $users = User::all();
    return response()->json($users);
});