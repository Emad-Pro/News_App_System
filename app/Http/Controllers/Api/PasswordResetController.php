<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordOtpMail; // 1. تأكد من استيراد كلاس البريد
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function sendResetLink(Request $request)
    {
        // 1. التحقق من الإيميل
        $request->validate(['email' => 'required|email|exists:users,email']);

        // 2. توليد الكود الرقمي
        $otp = rand(100000, 999999);
        
        // 3. حفظ الكود في الداتا بيز
        $user = User::where('email', $request->email)->first();
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(15)
        ]);

        // 4. إرسال الإيميل يدوياً (هنا التغيير المهم)
        // لا نستخدم Password::sendResetLink لأنها ترسل الرابط الافتراضي
        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp));
            
            return response()->json([
                'message' => 'تم إرسال رمز التحقق (OTP) المكون من 6 أرقام إلى بريدك.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ أثناء الإرسال.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}