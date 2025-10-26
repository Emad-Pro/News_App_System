<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                إدارة الفئات
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                إضافة فئة جديدة
            </a>
        </div>
    </x-slot>
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @if (session('success'))
            <div class="bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded-md shadow" role="alert">
                <p class="font-bold">نجاح!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 rounded-md shadow" role="alert">
                <p class="font-bold">خطأ!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 1. إضافة كلاسات الوضع المظلم للحاوية الرئيسية --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- 2. إضافة كلاسات الوضع المظلم للحاوية الداخلية والحدود --}}
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                {{-- 3. إضافة كلاسات الوضع المظلم لنصوص الهيدر --}}
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">الاسم</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">الرابط (Slug)</th>
                                <th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        {{-- 4. إضافة كلاسات الوضع المظلم لجسم الجدول --}}
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($categories as $category)
                                <tr>
                                    {{-- 5. إضافة كلاسات الوضع المظلم لنصوص الخلايا --}}
                                    <td class="px-6 py-4 text-gray-900 dark:text-gray-200">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-400">{{ $category->slug }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-left">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">تعديل</a>
                                        {{-- سنضيف زر الحذف لاحقًا --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>