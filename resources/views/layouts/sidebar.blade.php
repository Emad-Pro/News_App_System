<aside id="sidebar" class="fixed inset-y-0 right-0 z-30 w-64 bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-700 p-5 transform transition-transform duration-300 ease-in-out translate-x-full md:translate-x-0 md:relative md:inset-auto md:transform-none">
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center">
            <img src="https://img.icons8.com/?size=100&id=59843&format=png&color=4A6A5A" class="w-10 ml-2" alt="Logo">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">لوحة التحكم</h2>
        </div>
        <button id="close-sidebar-btn" class="md:hidden text-gray-600 dark:text-gray-300">
            <x-heroicon-o-x-mark class="w-6 h-6" />
        </button>
    </div>

    <nav class="space-y-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md">
            <x-heroicon-o-home class="w-5 h-5 ml-2 text-gray-500" />
            <span>الرئيسية</span>
        </a>
        <a href="{{ route('admin.articles.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md">
            <x-heroicon-o-document-text class="w-5 h-5 ml-2 text-gray-500" />
            <span>المقالات</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md">
            <x-heroicon-o-tag class="w-5 h-5 ml-2 text-gray-500" />
            <span>إدارة الفئات</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md">
            <x-heroicon-o-users class="w-5 h-5 ml-2 text-gray-500" />
            <span>المستخدمين</span>
        </a>
    </nav>
</aside>

<div id="sidebar-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden"></div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        // تأكد من وجود زر الفتح في navigation.blade.php
        const openBtn = document.getElementById('open-sidebar-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');
        const backdrop = document.getElementById('sidebar-backdrop');

        const openSidebar = () => {
            if(sidebar) sidebar.classList.remove('translate-x-full');
            if(backdrop) backdrop.classList.remove('hidden');
        };

        const closeSidebar = () => {
            if(sidebar) sidebar.classList.add('translate-x-full');
            if(backdrop) backdrop.classList.add('hidden');
        };

        if(openBtn) openBtn.addEventListener('click', openSidebar);
        if(closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if(backdrop) backdrop.addEventListener('click', closeSidebar);
    });
</script>
@endpush