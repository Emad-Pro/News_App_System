<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        
        <div class="flex items-center gap-3">
            <button id="open-sidebar-btn" class="md:hidden text-gray-600 dark:text-gray-300 focus:outline-none">
                <x-heroicon-o-bars-3 class="w-6 h-6" />
            </button>
            <span class="font-semibold text-gray-800 dark:text-gray-100">{{ config('app.name', 'Laravel') }}</span>
        </div>

        <div class="flex items-center gap-4">

            <div class="relative">
                <button id="notification-bell" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-gray-400 focus:outline-none">
                    <x-heroicon-o-bell class="h-6 w-6"/>
                    <span id="notification-badge" class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full hidden"></span>
                </button>
                
                <div id="notification-dropdown" class="absolute left-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hidden z-50">
                    <div class="p-4 font-semibold border-b dark:border-gray-700 text-gray-800 dark:text-gray-100">الإشعارات</div>
                    <div id="notification-list" class="divide-y dark:divide-gray-700 max-h-96 overflow-y-auto">
                        <p class="text-center text-gray-500 p-4">لا توجد إشعارات جديدة.</p>
                    </div>
                </div>
            </div>
            <span class="text-gray-600 dark:text-gray-300">{{ Auth::user()->name ?? 'Admin' }}</span>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-500 hover:underline">تسجيل خروج</button>
            </form>

        </div>
    </div>
</nav>