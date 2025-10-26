<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-950">
    <div class="relative min-h-screen md:flex">
        
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col">
            
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white dark:bg-gray-900 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    @stack('scripts') 
@auth
@if(Auth::user()->role === 'admin')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userId = {{ Auth::id() }};
        const notificationBell = document.getElementById('notification-bell');
        const notificationBadge = document.getElementById('notification-badge');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationList = document.getElementById('notification-list');
        
        let unreadCount = 0;

        // دالة لتحديث ظهور النقطة الحمراء على الجرس
        function updateBadgeVisibility() {
            if (unreadCount > 0) {
                notificationBadge.classList.remove('hidden');
            } else {
                notificationBadge.classList.add('hidden');
            }
        }

        // دالة لإنشاء عنصر HTML لكل إشعار في القائمة المنسدلة
        function createNotificationElement(notification) {
            const link = `/admin/articles/${notification.data.article_slug}#comment-${notification.data.comment_id}`;
            return `
                <a href="${link}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                        <span class="font-bold">${notification.data.user_name}</span> علّق للتو
                    </p>
                    <p class="text-xs text-gray-500 mt-1">على مقال "${notification.data.article_title}"</p>
                </a>
            `;
        }

        // دالة لجلب الإشعارات غير المقروءة من الخادم
        async function fetchUnreadNotifications() {
            try {
                const response = await fetch('{{ route("admin.notifications.index") }}');
                const notifications = await response.json();
                
                unreadCount = notifications.length;
                updateBadgeVisibility();
                
                notificationList.innerHTML = ''; // تفريغ القائمة قبل ملئها
                if (notifications.length === 0) {
                    notificationList.innerHTML = '<p class="text-center text-gray-500 p-4">لا توجد إشعارات جديدة.</p>';
                    return;
                }

                notifications.forEach(notification => {
                    notificationList.innerHTML += createNotificationElement(notification);
                });
            } catch (error) {
                console.error('Failed to fetch notifications:', error);
            }
        }

        // الاستماع للأحداث الجديدة في الوقت الفعلي عبر Echo
        window.Echo.private('App.Models.User.' + userId)
            .notification((notification) => {
                unreadCount++;
                updateBadgeVisibility();

                // عرض الإشعار المنبثق (Toast)
                Toastify({
                    text: `🔔 تعليق جديد من ${notification.user_name}`,
                    duration: 6000,
                    destination: `/admin/articles/${notification.article_slug}#comment-${notification.comment_id}`,
                    newWindow: false,
                    close: true,
                    gravity: "top",
                    position: "left",
                    style: {
                        background: "linear-gradient(to right, #4F46E5, #818CF8)",
                    },
                    stopOnFocus: true
                }).showToast();

                // إضافة الإشعار الجديد إلى أعلى القائمة المنسدلة
                const newNotificationHtml = createNotificationElement({ data: notification });
                if (notificationList.querySelector('p')) {
                    notificationList.innerHTML = '';
                }
                notificationList.insertAdjacentHTML('afterbegin', newNotificationHtml);
            });

        // تفعيل زر الجرس لفتح/إغلاق القائمة
        notificationBell.addEventListener('click', function(event) {
            event.stopPropagation();
            const isHidden = notificationDropdown.classList.toggle('hidden');
            
            if (!isHidden) { // إذا تم فتح القائمة
                fetchUnreadNotifications(); // ✨ هذا هو السطر المهم الذي يقوم بجلب الإشعارات عند الفتح

                // بعد 3 ثوانٍ، يتم تمييز الإشعارات كمقروءة وإخفاء النقطة الحمراء
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

        // إغلاق القائمة عند الضغط في أي مكان آخر خارجها
        window.addEventListener('click', function() {
            if (!notificationDropdown.classList.contains('hidden')) {
                notificationDropdown.classList.add('hidden');
            }
        });
        
        // جلب الإشعارات عند تحميل الصفحة لأول مرة لتحديد العدد الأولي
        fetchUnreadNotifications();
    });
</script>
@endif
@endauth
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('open-sidebar-btn');
        const closeBtn = document.getElementById('close-sidebar-btn');
        const backdrop = document.getElementById('sidebar-backdrop');

        // دالة لفتح القائمة
        const openSidebar = () => {
            sidebar.classList.remove('translate-x-full');
            backdrop.classList.remove('hidden');
        };

        // دالة لإغلاق القائمة
        const closeSidebar = () => {
            sidebar.classList.add('translate-x-full');
            backdrop.classList.add('hidden');
        };

        // ربط الأحداث بالأزرار
        openBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        backdrop.addEventListener('click', closeSidebar);
    });
</script>
@endpush
</body>
