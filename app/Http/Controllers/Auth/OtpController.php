<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class OtpController extends Controller
{
    // عرض صفحة طلب إرسال الـ OTP
    public function showRequestForm()
    {
        return view('auth.otp-request');
    }

    // إرسال الـ OTP للمستخدم
    public function sendOtp(Request $request)
    {
        $request->validate(['phone' => 'required|numeric']);

        $user = User::firstOrCreate(['phone' => $request->phone]);

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        // إرسال الرمز عبر Twilio
        $this->sendSms($user->phone, "Your OTP code is: " . $otp);

        return redirect()->route('otp.verify.form')->with('phone', $user->phone);
    }

    // عرض صفحة إدخال الـ OTP
    public function showVerifyForm()
    {
        return view('auth.otp-verify');
    }

    // التحقق من الـ OTP وتسجيل دخول المستخدم
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
            return back()->withErrors(['otp' => 'Invalid or expired OTP code.']);
        }

        // تسجيل دخول المستخدم
        Auth::login($user);
        $user->otp = null; // مسح الرمز بعد الاستخدام
        $user->otp_expires_at = null;
        $user->save();

        return redirect('/dashboard');
    }

    private function sendSms($recipient, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $token);

        $client->messages->create($recipient, [
            'from' => $from,
            'body' => $message
        ]);
    }
}