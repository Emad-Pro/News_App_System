    <x-app-layout>
        <x-slot name="header">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 px-6 py-4">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('messages.dashboard_title') }}
                </h2>
            </div>
        </x-slot>

        <div class="py-10 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                    <div>
                        <h3 class="text-sm font-medium text-gray-300">{{ __('messages.users_count') }}</h3>
                        <p class="text-3xl font-bold text-white mt-1">{{ $userCount }}</p>
                    </div>
                    <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                    <div>
                        <h3 class="text-sm font-medium text-gray-300">{{ __('messages.articles_count') }}</h3>
                        <p class="text-3xl font-bold text-white mt-1">{{ $articleCount }}</p>
                    </div>
                    <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                        <i class="fas fa-newspaper fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                    <div>
                        <h3 class="text-sm font-medium text-gray-300">{{ __('messages.comments_count') }}</h3>
                        <p class="text-3xl font-bold text-white mt-1">245</p>
                    </div>
                    <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                        <i class="fas fa-comments fa-lg"></i>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                    <div>
                        <h3 class="text-sm font-medium text-gray-300">{{ __('messages.today_visits') }}</h3>
                        <p class="text-3xl font-bold text-white mt-1">1,245</p>
                    </div>
                    <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                        <i class="fas fa-chart-line fa-lg"></i>
                    </div>
                </div>

            </div>

            <div class="mt-10 bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-8">
                <h3 class="text-xl font-bold text-white mb-2">
                    {{ __('messages.welcome_back', ['name' => Auth::user()->name ?? __('messages.admin')]) }}
                </h3>
                <p class="text-gray-300 leading-relaxed mb-6">
                    {{ __('messages.dashboard_description') }}
                </p>
                <a href="#" class="inline-block py-2 px-5 bg-[#00ADB5] hover:bg-[#02C39A] text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                    <i class="fas fa-plus-circle mr-2"></i>
                    {{ __('messages.add_new_article') }}
                </a>
            </div>
        </div>
    </x-app-layout>
    <script>
        // مثال بسيط لإظهار إشعار ترحيبي عند تحميل لوحة التحكم
        document.addEventListener('DOMContentLoaded', function () {
            Toastify({
                text: "{{ __('messages.welcome_back', ['name' => Auth::user()->name ?? __('messages.admin')]) }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            }).showToast();
        });
    </script>