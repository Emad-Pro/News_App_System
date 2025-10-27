<x-app-layout>
    {{-- 
        ملاحظة: تأكد من أن ملف app.blade.php يحتوي على 
        رابط Font Awesome لتظهر الأيقونات بشكل صحيح.
    --}}
    
    <x-slot name="header">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 px-6 py-4">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('لوحة التحكم الرئيسية') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">عدد المستخدمين</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $userCount }}</p>
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                    <i class="fas fa-users fa-lg"></i>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">عدد المقالات</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $articleCount }}</p>
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                     <i class="fas fa-newspaper fa-lg"></i>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">عدد التعليقات</h3>
                    <p class="text-3xl font-bold text-white mt-1">245</p> {{-- يمكنك تغيير هذا الرقم لمتغير ديناميكي --}}
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                     <i class="fas fa-comments fa-lg"></i>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">زيارات اليوم</h3>
                    <p class="text-3xl font-bold text-white mt-1">1,245</p> {{-- يمكنك تغيير هذا الرقم لمتغير ديناميكي --}}
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                     <i class="fas fa-chart-line fa-lg"></i>
                </div>
            </div>

        </div>

        <div class="mt-10 bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-8">
            <h3 class="text-xl font-bold text-white mb-2">مرحباً بعودتك، {{ Auth::user()->name ?? 'المسؤول' }} 👋</h3>
            <p class="text-gray-300 leading-relaxed mb-6">
                من هنا يمكنك إدارة المستخدمين، الإشراف على المقالات، وتتبع الإحصائيات اليومية لموقعك.
            </p>
            <a href="#" class="inline-block py-2 px-5 bg-[#00ADB5] hover:bg-[#02C39A] text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle mr-2"></i>
                إضافة مقال جديد
            </a>
        </div>
    </div>
</x-app-layout>