<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordOtpMail;
use Illuminate\Support\Facades\Hash; // 👈 هذا السطر هو سبب الخطأ غالباً (كان مفقوداً)
use Carbon\Carbon; // 👈 وهذا أيضاً للتعامل مع الوقت
use Illuminate\Support\Facades\Log; // تأكد من إضافة هذا السطر في أعلى الملف
class PasswordResetController extends Controller
{
    // 1. دالة إرسال الكود
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        
        $user = User::where('email', $request->email)->first();
        
        // حفظ الكود
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15)
        ]);

        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp));
            return response()->json(['message' => 'تم إرسال رمز التحقق.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'فشل الإرسال.', 'error' => $e->getMessage()], 500);
        }
    }

    // 2. دالة إعادة التعيين (التي تسبب المشكلة)
    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'otp' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'المستخدم غير موجود.'], 404);
    }

    // --- أدوات التشخيص (Debugging) ---
    // هذا السطر سيكتب القيم في ملف storage/logs/laravel.log
    // افتح الملف لتعرف لماذا يرى السيرفر أن الأرقام غير متطابقة
    Log::info("مقارنة الكود للمستخدم {$user->email}: المخزن [{$user->otp_code}] - المرسل [{$request->otp}]");

    // 1. تنظيف المدخلات (إزالة المسافات)
$submittedOtp = trim((string) $request->otp);
    $storedOtp = trim((string) $user->otp_code);

    // 2. المقارنة وكشف القيم في حالة الخطأ
    if ($submittedOtp !== $storedOtp) {
        return response()->json([
            'message' => 'رمز التحقق غير صحيح.',
            // 🚨 هذا الجزء سيكشف لك السر - احذفه بعد الحل
            'server_stored_otp' => $storedOtp, // الكود الموجود في الداتا بيز
            'you_sent_otp' => $submittedOtp,   // الكود الذي أرسلته أنت
            'type_stored' => gettype($storedOtp),
            'type_sent' => gettype($submittedOtp),
        ], 400);
    }

    // 3. التحقق من الوقت
    if (Carbon::now()->gt($user->otp_expires_at)) {
        return response()->json(['message' => 'انتهت صلاحية الرمز.'], 400);
    }

    // 4. تغيير كلمة المرور
    $user->forceFill([
        'password' => Hash::make($request->password),
        'otp_code' => null,
        'otp_expires_at' => null
    ])->save();

    return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح.']);
}
}