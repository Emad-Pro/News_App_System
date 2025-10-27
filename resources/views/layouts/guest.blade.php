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

        {{-- تم إضافة بعض التنسيقات العامة هنا --}}
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        {{-- 
            تم تغيير الخلفية هنا لتطابق الثيم العام.
            وتم تغيير هيكل البطاقة لتصبح زجاجية.
        --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-[#283E51] to-[#485563] px-4">
            
            {{-- 
                تم إزالة الشعار من هنا ليكون جزءاً من كل صفحة على حدة (مثل صفحة الدخول)،
                وهذا يعطي مرونة أكبر في التصميم.
            --}}

            {{-- البطاقة الزجاجية التي ستحتوي على النموذج --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/10 backdrop-blur-lg shadow-xl border border-white/20 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>