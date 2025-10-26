<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('لوحة التحكم الرئيسية') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- بطاقة: المستخدمين -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 flex items-center justify-between hover:shadow-md transition">
                <div>
                    <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد المستخدمين</h3>
                    <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $userCount }}</p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 p-3 rounded-lg">
                    <x-heroicon-o-users class="w-6 h-6" />
                </div>
            </div>

            <!-- بطاقة: المقالات -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 flex items-center justify-between hover:shadow-md transition">
                <div>
                    <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد المقالات</h3>
                    <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $articleCount }}</p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 p-3 rounded-lg">
                    <x-heroicon-o-document-text class="w-6 h-6" />
                </div>
            </div>

            <!-- بطاقة: التعليقات -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 flex items-center justify-between hover:shadow-md transition">
                <div>
                    <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد التعليقات</h3>
                    <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">245</p>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 p-3 rounded-lg">
                    <x-heroicon-o-chat-bubble-left-ellipsis class="w-6 h-6" />
                </div>
            </div>

            <!-- بطاقة: الزيارات -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 flex items-center justify-between hover:shadow-md transition">
                <div>
                    <h3 class="text-sm text-gray-500 dark:text-gray-400">زيارات اليوم</h3>
                    <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">1,245</p>
                </div>
                <div class="bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 p-3 rounded-lg">
                    <x-heroicon-o-chart-bar class="w-6 h-6" />
                </div>
            </div>

        </div>

        <!-- قسم إضافي -->
        <div class="mt-10 bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">مرحباً، {{ Auth::user()->name ?? 'المسؤول' }} 👋</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                من هنا يمكنك إدارة المستخدمين، الإشراف على المقالات، وتتبع الإحصائيات اليومية لموقعك.
            </p>
        </div>
    </div>
</x-app-layout>
