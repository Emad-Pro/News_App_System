<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>

{{-- تم تعديل الخلفية هنا لتطبيق الثيم المظلم --}}
<body class="font-sans antialiased bg-gradient-to-br from-[#283E51] to-[#485563]">
    <div class="relative min-h-screen md:flex">
        
        {{-- القائمة الجانبية (Sidebar) --}}
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">
            
            {{-- شريط التنقل العلوي (Navigation) --}}
            @include('layouts.navigation')

            {{-- رأس الصفحة (Header) --}}
            @if (isset($header))
                {{-- تم تعديل تصميم الهيدر ليصبح زجاجيًا --}}
                <header class="px-4 sm:px-6 lg:px-8 mt-6">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 px-6 py-4">
                        {{ $header }}
                    </div>
                </header>
            @endif

            {{-- المحتوى الرئيسي للصفحة --}}
            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- CDN Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- سكربتات خاصة بكل صفحة --}}
    @stack('scripts') 

@auth
@if(Auth::user()->role === 'admin')
<script>
    // --- سكربت الإشعارات مع تعديلات على التصميم ---
    document.addEventListener('DOMContentLoaded', function () {
        const userId = {{ Auth::id() }};
        const notificationBell = document.getElementById('notification-bell');
        const notificationBadge = document.getElementById('notification-badge');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationList = document.getElementById('notification-list');
        
        let unreadCount = 0;

        function updateBadgeVisibility() {
            if (unreadCount > 0) {
                notificationBadge.classList.remove('hidden');
            } else {
                notificationBadge.classList.add('hidden');
            }
        }

        // تم تعديل تصميم عنصر الإشعار هنا
        function createNotificationElement(notification) {
            const link = `/admin/articles/${notification.data.article_slug}#comment-${notification.data.comment_id}`;
            return `
                <a href="${link}" class="block p-4 hover:bg-white/10 border-b border-white/20 transition duration-200">
                    <p class="text-sm font-semibold text-white">
                        <span class="font-bold">${notification.data.user_name}</span> علّق للتو
                    </p>
                    <p class="text-xs text-gray-300 mt-1">على مقال "${notification.data.article_title}"</p>
                </a>
            `;
        }

        async function fetchUnreadNotifications() {
            try {
                const response = await fetch('{{ route("admin.notifications.index") }}');
                const notifications = await response.json();
                
                unreadCount = notifications.length;
                updateBadgeVisibility();
                
                notificationList.innerHTML = '';
                if (notifications.length === 0) {
                    notificationList.innerHTML = '<p class="text-center text-gray-400 p-4">لا توجد إشعارات جديدة.</p>';
                    return;
                }

                notifications.forEach(notification => {
                    notificationList.innerHTML += createNotificationElement(notification);
                });
            } catch (error) {
                console.error('Failed to fetch notifications:', error);
            }
        }

        window.Echo.private('App.Models.User.' + userId)
            .notification((notification) => {
                unreadCount++;
                updateBadgeVisibility();

                // تم تعديل تصميم الإشعار المنبثق (Toast) هنا
                Toastify({
                    text: `🔔 تعليق جديد من ${notification.user_name}`,
                    duration: 6000,
                    destination: `/admin/articles/${notification.article_slug}#comment-${notification.comment_id}`,
                    newWindow: false,
                    close: true,
                    gravity: "top",
                    position: "left", // 'left' in LTR, so it appears on the right in RTL
                    style: {
                        background: "linear-gradient(to right, #00ADB5, #02C39A)",
                        "border-radius": "10px",
                    },
                    stopOnFocus: true
                }).showToast();

                const newNotificationHtml = createNotificationElement({ data: notification });
                if (notificationList.querySelector('p')) {
                    notificationList.innerHTML = '';
                }
                notificationList.insertAdjacentHTML('afterbegin', newNotificationHtml);
            });

        notificationBell.addEventListener('click', function(event) {
            event.stopPropagation();
            const isHidden = notificationDropdown.classList.toggle('hidden');
            
            if (!isHidden) {
                fetchUnreadNotifications();

                setTimeout(() => {
                    fetch('{{ route("admin.notifications.markAsRead") }}', { 
                        method: 'POST', 
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    unreadCount = 0;
                    updateBadgeVisibility();
                }, 3000);
            }
        });

        window.addEventListener('click', function() {
            if (!notificationDropdown.classList.contains('hidden')) {
                notificationDropdown.classList.add('hidden');
            }
        });
        
        fetchUnreadNotifications();
    });
</script>
@endif
@endauth

{{-- سكربت القائمة الجانبية (لا يحتاج لتعديل) --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('open-sidebar-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');
        const backdrop = document.getElementById('sidebar-backdrop');
        const openSidebar = () => {
            sidebar.classList.remove('translate-x-full');
            backdrop.classList.remove('hidden');
        };
        const closeSidebar = () => {
            sidebar.classList.add('translate-x-full');
            backdrop.classList.add('hidden');
        };
        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        backdrop.addEventListener('click', closeSidebar);
    });
</script>
@endpush
</body>
</html>