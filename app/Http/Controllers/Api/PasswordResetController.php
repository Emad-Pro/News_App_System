<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PasswordResetController extends Controller
{
    /**
     * الخطوة 1: إرسال رابط إعادة التعيين
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // هذا السطر يقوم بكل العمل: يولد الرمز ويرسل الإيميل
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent successfully.']);
        }

        // إذا فشل (مثلاً الإيميل غير موجود)
        return response()->json(['message' => 'Unable to send password reset link.'], 400);
    }

    /**
     * الخطوة 2: تحديث كلمة المرور
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        // هذا السطر يتحقق من الرمز والبريد ثم يقوم بالتحديث
        $status = Password::reset($request->all(), function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password has been reset successfully.']);
        }

        return response()->json(['message' => 'Invalid token or email.'], 400);
    }
}