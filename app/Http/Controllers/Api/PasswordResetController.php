<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordOtpMail;
use Illuminate\Support\Facades\Hash; // 👈 هذا السطر هو سبب الخطأ غالباً (كان مفقوداً)
use Carbon\Carbon; // 👈 وهذا أيضاً للتعامل مع الوقت

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
        // التحقق من المدخلات
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // جلب المستخدم
        $user = User::where('email', $request->email)->first();

        // 1. التأكد من أن المستخدم موجود (حماية إضافية لتجنب خطأ 500)
        if (!$user) {
            return response()->json(['message' => 'المستخدم غير موجود.'], 404);
        }

        // 2. التأكد من صحة الكود
        // نستخدم (string) لضمان مقارنة نصوص حتى لو كان الرقم يبدأ بصفر
        if ((string)$user->otp_code !== (string)$request->otp) {
            return response()->json(['message' => 'رمز التحقق غير صحيح.'], 400);
        }

        // 3. التأكد من صلاحية الوقت
        if (!$user->otp_expires_at || Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['message' => 'انتهت صلاحية الرمز.'], 400);
        }

        // 4. تحديث كلمة المرور (هنا نستخدم Hash)
        $user->forceFill([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expires_at' => null
        ])->save();

        return response()->json([
            'message' => 'تم تغيير كلمة المرور بنجاح. قم بتسجيل الدخول الآن.'
        ], 200);
    }
}