<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // إعادة توجيه المستخدم إلى صفحة جوجل للتوثيق
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // معالجة الـ callback من جوجل
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'google_id' => $googleUser->id,
            ], [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,
                'password' => bcrypt(str_random(16)) // كلمة مرور عشوائية
            ]);

            Auth::login($user);

            return redirect('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Something went wrong or you have cancelled the login.');
        }
    }
}
