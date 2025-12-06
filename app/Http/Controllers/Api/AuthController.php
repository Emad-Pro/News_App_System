<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    public function loginWithEmail(Request $request)
{
    // 1. التحقق من المدخلات
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 2. البحث عن المستخدم بواسطة البريد الإلكتروني
    $user = User::where('email', $request->email)->first();

    // 3. التحقق من وجود المستخدم وصحة كلمة المرور
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid login details'
        ], 401);
    }

    // 4. إنشاء وإرجاع التوكن
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User logged in successfully',
        'user' => $user,
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}
    public function registerWithEmail(Request $request)
{
    
    // 1. تحديث قواعد التحقق
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // 2048 KB = 2MB
    ]);

    // 2. معالجة رفع الصورة إن وجدت
    $avatarPath = null;
    if ($request->hasFile('avatar')) {
        // تخزين الصورة في storage/app/public/avatars
        // وإرجاع المسار النسبي لها
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
    }

    // 3. إنشاء المستخدم مع مسار الصورة
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'auth_provider' => 'email',
        'avatar' => $avatarPath, // حفظ مسار الصورة في قاعدة البيانات
    ]);

    // 4. إنشاء التوكن
    $token = $user->createToken('auth_token')->plainTextToken;

    // 5. إرجاع بيانات المستخدم (مع رابط الصورة الكامل)
    return response()->json([
        'message' => 'User registered successfully',
        'user' => $user->refresh(), // نستخدم refresh لجلب البيانات المحدثة مع رابط الصورة
        'access_token' => $token,
        'token_type' => 'Bearer',
    ], 201);
}
public function registerWithPhone(Request $request)
{
        // 1. التحقق من جميع البيانات المدخلة (مثل التسجيل بالإيميل)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // 2. معالجة رفع الصورة الشخصية (إن وجدت)
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // 3. إنشاء المستخدم بكل بياناته
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'avatar' => $avatarPath,
        ]);

        // 4. إنشاء رمز التحقق وحفظه
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10); // زيادة مدة الصلاحية
        $user->save();

        // 5. إرسال الرمز عبر خدمة الرسائل (مثل Twilio)
        // TODO: قم بإلغاء التعليق وتفعيل هذه الخدمة في بيئة الإنتاج
        // $this->sendSms($user->phone, "Your verification code is: " . $otp);

        // 6. إرجاع رسالة نجاح توضح الخطوة التالية
        return response()->json([
            'message' => 'User registered successfully. Please verify your phone to login.',
            'phone' => $user->phone,
            // ملاحظة: في بيئة التطوير، يمكنك إرجاع الـ OTP لتسهيل الاختبار
            'development_otp' => $otp
        ], 201); // 201 Created
}
// الخطوة 2: التحقق من الرمز وإصدار التوكن
public function verifyOtp(Request $request)
{
    $request->validate([
        'phone' => 'required|numeric',
        'otp' => 'required|numeric',
    ]);

    $user = User::where('phone', $request->phone)
                ->where('otp', $request->otp)
                ->where('otp_expires_at', '>', now())
                ->first();

    if (!$user) {
        return response()->json(['message' => 'Invalid or expired OTP.'], 401);
    }

    // مسح الرمز بعد استخدامه
    $user->otp = null;
    $user->otp_expires_at = null;
    $user->save();
    
    // إنشاء التوكن
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User logged in successfully',
        'user' => $user,
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}
public function authWithGoogle(Request $request)
    {
        // 1. استقبال الـ id_token القادم من الموبايل
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            // 2. التحقق من التوكن عبر Socialite
            // هذه الخطوة تتصل بجوجل للتأكد أن التوكن سليم ولم يتم التلاعب به
            $socialiteUser = Socialite::driver('google')->userFromToken($request->id_token);

            // 3. البحث عن المستخدم أو إنشاؤه في قاعدة بياناتك
            $user = User::updateOrCreate(
                [
                    'google_id' => $socialiteUser->getId(), // نبحث عنه بواسطة ID جوجل
                ],
                [
                    'name'              => $socialiteUser->getName(),
                    'email'             => $socialiteUser->getEmail(),
                    'google_id'         => $socialiteUser->getId(),
                    'avatar'            => $socialiteUser->getAvatar(),
                    'email_verified_at' => now(), // نعتبره موثقاً لأنه قادم من جوجل
                    'password'          => Hash::make(Str::random(24)), // باسورد عشوائي لأنه لن يستخدمه
                    'auth_provider'     => 'google', // لتسجيل طريقة الدخول
                ]
            );

            // 4. إنشاء توكن خاص بتطبيقك (Sanctum Token)
            $token = $user->createToken('google-mobile-login')->plainTextToken;

            // 5. الرد بنجاح
            return response()->json([
                'message'      => 'User authenticated successfully',
                'user'         => $user,
                'access_token' => $token,
                'token_type'   => 'Bearer',
            ], 200);

        } catch (\Exception $e) {
            // تسجيل الخطأ في الملفات بدلاً من إيقاف السيرفر
            Log::error('Google Auth Failed: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Authentication failed',
                'error'   => $e->getMessage() // (اختياري) يمكنك إزالته في الإنتاج
            ], 401);
        }
    }
public function logout(Request $request)
{
    // الحصول على التوكن الذي استخدمه المستخدم لإجراء هذا الطلب وحذفه
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'User logged out successfully.'
    ]);
}
}
