{{-- تأكد أن layouts/guest.blade.php يحتوي على:
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
--}}

<x-guest-layout>
    {{-- لا تضف <head> هنا — اجعلها في layout كما في الملاحظة أعلاه --}}

    {{-- أضفت dir="rtl" و lang="ar" للتأكيد --}}
    <div dir="rtl" lang="ar" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#283E51] to-[#485563] px-4" style="font-family: 'Cairo', sans-serif;">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-6 sm:p-8 space-y-6">
            <div class="text-center">
                <div class="mx-auto bg-[#00ADB5]/20 p-3 rounded-full w-16 h-16 flex items-center justify-center shadow-md">
                    <i class="fas fa-lock text-3xl text-[#00ADB5]"></i>
                </div>
                <h2 class="mt-4 text-xl sm:text-2xl font-bold text-white">
                    {{ __('تسجيل الدخول إلى لوحة التحكم') }}
                </h2>
                <p class="text-gray-300 text-xs sm:text-sm mt-1">
                    👋 أهلاً بعودتك، من فضلك أدخل بياناتك للمتابعة
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-sm text-center text-green-400" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-1">البريد الإلكتروني</label>
                    <div class="relative">
                        {{-- لقد وضعت الأيقونة في الجهة اليسرى لأننا في RTL نضعها على اليسار --}}
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        {{-- استبدلت pr-10 بـ pl-10 لترك مساحة على اليسار (حيث الأيقونة) --}}
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full rounded-lg border border-gray-600 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition pl-10 pr-3 py-2 text-sm sm:text-base" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-key text-gray-400"></i>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                               class="w-full rounded-lg border border-gray-600 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition pl-10 pr-3 py-2 text-sm sm:text-base" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="rounded border-gray-500 bg-gray-900/50 text-[#00ADB5] shadow-sm focus:ring-[#00ADB5]">
                        <span class="mr-2 text-sm text-gray-300">تذكرني</span>
                    </label>

                    {{-- لو أردت تفعيل "نسيت كلمة المرور؟" أزل التعليق هنا --}}
                    {{-- @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-[#00ADB5] hover:text-[#02C39A] hover:underline transition">
                            نسيت كلمة المرور؟
                        </a>
                    @endif --}}
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full flex items-center justify-center py-3 bg-[#00ADB5] hover:bg-[#02C39A] text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-[1.03]">
                        {{-- في RTL حركت أيقونة السهم إلى اليسار مستخدماً ml-2 --}}
                        تسجيل الدخول
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>

            <div class="border-t border-white/20 pt-4 text-center">
                <p class="text-xs text-gray-400">
                    تم التصميم بواسطة 💻 Eng. <span class="text-[#00ADB5] font-semibold">Emad Younis</span>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
