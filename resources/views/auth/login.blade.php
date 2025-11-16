<x-guest-layout>
    {{-- 
      ملاحظة: تم إزالة وسم <head> الزائد
      و <div class="min-h-screen..."> الخارجي.
      المكون <x-guest-layout> يعتني بكل هذا الآن.
    --}}

    {{-- البطاقة الزجاجية مباشرة --}}
    <div class="w-full max-w-md bg-white/10 backdrop-blur-lg rounded-2xl shadow-xl border border-white/20 p-8 space-y-6">

        <div class="text-center">
            <div class="mx-auto bg-[#00ADB5]/20 p-3 rounded-full w-16 h-16 flex items-center justify-center shadow-md">
                <i class="fas fa-lock text-3xl text-[#00ADB5]"></i>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-white">
                {{ __('تسجيل الدخول إلى لوحة التحكم') }}
            </h2>
            <p class="text-gray-300 text-sm mt-1">
                👋 أهلاً بعودتك، من فضلك أدخل بياناتك للمتابعة
            </p>
        </div>

        <x-auth-session-status class="mb-4 text-sm text-center text-green-400" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">البريد الإلكتروني</label>
                <div class="relative">
                    <span class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-10' }}" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">كلمة المرور</label>
                <div class="relative">
                     <span class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                        <i class="fas fa-key text-gray-400"></i>
                    </span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition {{ app()->getLocale() == 'ar' ? 'pr-10' : 'pl-10' }}" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="rounded border-gray-500 bg-gray-900/50 text-[#00ADB5] shadow-sm focus:ring-[#00ADB5]">
                    <span class="{{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} text-sm text-gray-300">تذكرني</span>
                </label>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full flex items-center justify-center py-3 bg-[#00ADB5] hover:bg-[#02C39A] text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    تسجيل الدخول
                    <i class="fas fa-arrow-right {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}"></i>
                </button>
            </div>
        </form>

        <div class="border-t border-white/20 pt-4 text-center">
            <p class="text-xs text-gray-400">
                تم التصميم بواسطة 💻 Eng. <span class="text-[#00ADB5] font-semibold">Emad Younis</span>
            </p>
        </div>
    </div>
</x-guest-layout>

