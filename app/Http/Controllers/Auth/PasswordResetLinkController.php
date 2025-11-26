<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordOtpMail; // استيراد كلاس الإيميل
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // 1. دالة إرسال الكود (Send OTP)
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // توليد كود عشوائي من 6 أرقام
        $otp = rand(100000, 999999);
        
        $user = User::where('email', $request->email)->first();
        
        // حفظ الكود ووقت الانتهاء (بعد 15 دقيقة) في قاعدة البيانات
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15)
        ]);

        // إرسال الإيميل
        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp));
            
            return response()->json([
                'message' => 'تم إرسال رمز التحقق إلى بريدك الإلكتروني.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء إرسال الإيميل.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 2. دالة تغيير كلمة المرور (Reset Password)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6', // التأكد أن الكود 6 أرقام
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        // التحقق من صحة الكود
        if ($user->otp_code !== $request->otp) {
            return response()->json(['message' => 'رمز التحقق غير صحيح.'], 400);
        }

        // التحقق من صلاحية الوقت
        if (Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['message' => 'انتهت صلاحية رمز التحقق، حاول مرة أخرى.'], 400);
        }

        // تحديث كلمة المرور وتنظيف الكود
        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'otp_expires_at' => null
        ]);

        return response()->json([
            'message' => 'تم تغيير كلمة المرور بنجاح. يمكنك تسجيل الدخول الآن.'
        ]);
    }
}