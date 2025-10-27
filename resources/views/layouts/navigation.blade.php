<nav class="bg-transparent border-b border-white/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        
        <div class="flex items-center gap-3">
            <button id="open-sidebar-btn" class="md:hidden text-gray-300 hover:text-white focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <span class="font-semibold text-white hidden sm:block">{{ config('app.name', 'Laravel') }}</span>
        </div>

        <div class="flex items-center gap-5">

            <div class="relative">
                <button id="notification-bell" class="relative p-2 text-gray-300 rounded-full hover:bg-white/10 hover:text-white focus:outline-none transition-colors">
                    <i class="fas fa-bell"></i>
                    <span id="notification-badge" class="absolute top-0 right-0 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-[#3a4756] hidden"></span>
                </button>
                
                <div id="notification-dropdown" class="absolute left-0 mt-3 w-80 bg-black/60 backdrop-blur-lg border border-white/20 rounded-lg shadow-lg overflow-hidden hidden z-50">
                    <div class="p-4 font-semibold border-b border-white/20 text-white">الإشعارات</div>
                    <div id="notification-list" class="max-h-96 overflow-y-auto">
                        {{-- يتم ملء الإشعارات هنا عبر JavaScript --}}
                        <p class="text-center text-gray-400 p-4">لا توجد إشعارات جديدة.</p>
                    </div>
                </div>
            </div>
            
            <span class="text-gray-200 font-medium hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-2 text-gray-300 rounded-full hover:bg-red-500/50 hover:text-white focus:outline-none transition-colors" title="تسجيل خروج">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>

        </div>
    </div>
</nav>