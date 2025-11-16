<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- خطوط وأيقونات --}}
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

<link rel="stylesheet" href="/build/assets/app-BfC1Evvt.css">

    <style>
        /* ضمان تطبيق الخط على كل النصوص */
        body { font-family: 'Cairo', sans-serif; }

        /* حاوية البطاقة: تستخدم خصائص منطقية لتعمل مع rtl & ltr */
        .glass {
            -webkit-backdrop-filter: blur(8px);
            backdrop-filter: blur(8px);
            background-color: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.18);
        }

        /* تصغير البادينغ على الشاشات الصغيرة وعدم قص العناصر */
        .glass-inner {
            padding: 1rem;           /* mobile default */
        }
        @media (min-width: 640px) {
            .glass-inner { padding: 2rem; }
        }

        /* مساعدة لو كان داخل الـ slot حقول فيها أيقونات absolute */
        .input-with-icon { position: relative; }
        .input-with-icon .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            inset-inline-start: 0.75rem; /* يعمل في rtl & ltr */
            pointer-events: none;
            color: rgba(156,163,175,1); /* text-gray-400 */
            font-size: 1rem;
        }
        /* نضيف padding منطقي لنص الحقل حتى لا يتقاطع مع الأيقونة */
        .input-with-icon input,
        .input-with-icon textarea {
            padding-inline-start: 2.5rem; /* للـ ltr سيصبح padding-left، للـ rtl padding-right */
        }

        /* منع overflow clipping على الهواتف (يساعد لو في تأثيرات focus أو shadows) */
        .no-clip { overflow: visible; }

        /* تحسينات أداء للجوال: قلل تأثير blur وshadow على الشاشات الصغيرة إن احتجت */
        @media (max-width: 420px) {
            .glass { -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px); }
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#283E51] to-[#485563] px-4">
        {{-- الحاوية الخارجية مُعدّة بصورة استجابية --}}
        <div class="w-full max-w-sm sm:max-w-md mt-6 px-4 sm:px-6 py-6 glass sm:rounded-2xl shadow-xl no-clip">
            <div class="glass-inner">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
