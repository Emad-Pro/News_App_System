<aside id="sidebar" class="fixed inset-y-0 right-0 z-30 w-64 bg-black/30 backdrop-blur-lg border-l border-white/20 p-5 transform transition-transform duration-300 ease-in-out translate-x-full md:translate-x-0 md:relative md:inset-auto md:transform-none">
    <div class="flex items-center justify-between mb-10">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <img src="https://img.icons8.com/?size=100&id=59843&format=png&color=00ADB5" class="w-10" alt="Logo">
            <h2 class="text-xl font-bold text-white">لوحة التحكم</h2>
        </a>
        <button id="close-sidebar-btn" class="md:hidden text-gray-300 hover:text-white">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <nav class="space-y-2">
        {{-- دالة is_active لتحديد الرابط النشط --}}
        @php
            function is_active($routeName) {
                return request()->routeIs($routeName) 
                    ? 'bg-[#00ADB5] text-white shadow-lg' 
                    : 'text-gray-300 hover:bg-white/10 hover:text-white';
            }
        @endphp

        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 {{ is_active('admin.dashboard') }}">
            <i class="fas fa-home w-5 text-center mr-3"></i>
            <span>الرئيسية</span>
        </a>
        <a href="{{ route('admin.articles.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 {{ is_active('admin.articles.*') }}">
            <i class="fas fa-newspaper w-5 text-center mr-3"></i>
            <span>المقالات</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 {{ is_active('admin.categories.*') }}">
            <i class="fas fa-tags w-5 text-center mr-3"></i>
            <span>إدارة الفئات</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition-colors duration-200 {{ is_active('admin.users.*') }}">
            <i class="fas fa-users w-5 text-center mr-3"></i>
            <span>المستخدمين</span>
        </a>
    </nav>
</aside>

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