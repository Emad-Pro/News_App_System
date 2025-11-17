<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" dir="{{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script>
        // 1. منع وميض اللغة (يقرأ من ذاكرة المتصفح)
        if (localStorage.getItem('locale') === 'ar') {
            document.documentElement.dir = 'rtl';
        } else if (localStorage.getItem('locale') === 'en') {
            document.documentElement.dir = 'ltr';
        }

        // 2. منع وميض الوضع المظلم (يقرأ من ذاكرة المتصفح)
        if (localStorage.getItem('color-theme') === 'dark' || 
           (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <title>{{ __('messages.welcome_title') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen 
             bg-gradient-to-br from-[#283E51] to-[#485563] 
             text-gray-100 dark:text-gray-100 
             text-center p-5 transition-colors duration-300">

    <div class="absolute top-4 end-4 flex items-center gap-3">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="p-2 text-gray-300 rounded-full hover:bg-white/20 hover:text-white focus:outline-none transition-colors">
                <i class="fas fa-globe"></i>
            </button>
            <div x-show="open" 
                 @click.away="open = false" 
                 x-transition
                 class="absolute ltr:right-0 rtl:left-0 mt-3 w-36 bg-black/60 backdrop-blur-lg border border-white/20 rounded-lg shadow-lg overflow-hidden z-50">
                
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                       class="block px-4 py-2 text-sm text-gray-200 hover:bg-white/10 {{ app()->getLocale() == $localeCode ? 'bg-white/20' : '' }}">
                        {{ $properties['native'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <button id="theme-toggle" type="button" class="p-2 text-gray-300 rounded-full hover:bg-white/20 hover:text-white focus:outline-none transition-colors">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
        </button>
    </div>
    <main class="flex-1 flex items-center justify-center w-full">
        <div class="bg-white/5 backdrop-blur-lg rounded-2xl p-8 md:p-10 shadow-2xl border border-white/10 w-full max-w-2xl">
            
            <h1 class="text-3xl md:text-4xl mb-5 text-white font-bold">
                {{ __('messages.welcome_title') }}
            </h1>
            
            <p class="text-lg my-2 leading-relaxed text-gray-200 dark:text-gray-200">
                {{ __('messages.welcome_description') }}
            </p>

            <div class="mt-8 text-start ltr:text-left rtl:text-right border-t border-white/20 pt-5">
                <h2 class="text-lg md:text-xl mb-4 text-[#00ADB5] font-semibold">
                    <i class="fas fa-rocket ltr:mr-2.5 rtl:ml-2.5"></i>{{ __('messages.latest_updates') }}
                </h2>
                <ul class="list-none p-0 m-0">
                    <li class="py-1.5 text-base opacity-90"><i class="fas fa-check-circle text-green-400 ltr:mr-2.5 rtl:ml-2.5"></i> {{ __('messages.update_api_speed') }} </li>
                    <li class="py-1.5 text-base opacity-90"><i class="fas fa-palette text-blue-400 ltr:mr-2.5 rtl:ml-2.5"></i> {{ __('messages.update_design') }} </li>
                    <li class="py-1.5 text-base opacity-90"><i class="fas fa-shield-alt text-red-400 ltr:mr-2.5 rtl:ml-2.5"></i>{{ __('messages.update_security') }} </li>
                </ul>
            </div>

            <div class="mt-10 flex flex-wrap justify-center gap-4 flex-col items-center sm:flex-row">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2.5 py-3 px-7 rounded-full font-semibold text-base transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg bg-[#00ADB5] text-white">
                    <i class="fas fa-tachometer-alt"></i>
                    {{ __('messages.go_to_dashboard') }}
                </a>
                <a href="#" id="openVideoBtn" class="inline-flex items-center gap-2.5 py-3 px-7 rounded-full font-semibold text-base transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg bg-white/10 text-white">
                    <i class="fas fa-play-circle"></i>
                    {{ __('messages.watch_demo') }}
                </a>
            </div>
        </div>
    </main>

    <footer class="w-full text-center py-5 text-sm text-gray-400">
        &copy; {{ date('Y') }} {{ __('messages.footer_text') }}
    </footer>

    <div id="videoModal" class="hidden fixed z-[1000] inset-0 bg-black/80 backdrop-blur-sm items-center justify-center">
        <div class="relative w-11/12 max-w-3xl">
            <span class="close-button absolute -top-10 ltr:right-0 rtl:left-0 text-white text-4xl font-bold cursor-pointer transition-colors duration-200 hover:text-[#00ADB5]">&times;</span>
            <div class="relative aspect-video w-full">
                <iframe id="demoVideo" class="absolute inset-0 w-full h-full rounded-lg" src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <script>
        // --- سكربت مزامنة اللغة (لحفظ الاختيار للزيارة القادمة) ---
        localStorage.setItem('locale', '{{ app()->getLocale() }}');

        // --- سكربت النافذة المنبثقة للفيديو ---
        const modal = document.getElementById('videoModal');
        const openBtn = document.getElementById('openVideoBtn');
        const closeBtn = document.querySelector('.close-button');
        const videoFrame = document.getElementById('demoVideo');
        const videoSrc = videoFrame.src; 

        openBtn.onclick = function(e) {
            e.preventDefault();
            modal.style.display = 'flex';
            videoFrame.src = videoSrc;
        }

        function closeModal() {
            modal.style.display = 'none';
            videoFrame.src = '';
        }
        closeBtn.onclick = closeModal;
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        // --- سكربت التحكم بالوضع المظلم ---
        document.addEventListener('DOMContentLoaded', function () {
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            var themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        });
    </script>
    </body>
</html>