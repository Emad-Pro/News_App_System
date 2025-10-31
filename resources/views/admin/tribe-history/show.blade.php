<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('messages.event_details') }}: {{ $history->title }}
            </h2>
            <a href="{{ route('admin.histories.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600/50 hover:bg-gray-500/50 text-white font-semibold rounded-lg shadow-md transition duration-300">
                <i class="fas fa-arrow-right"></i>
                {{ __('messages.back_to_list') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-8 text-white">
                    <div class="mb-6 pb-4 border-b border-white/20">
                        <h3 class="text-3xl font-bold">{{ $history->title }}</h3>
                        <p class="mt-2 text-lg text-gray-300"><i class="fas fa-calendar-alt fa-fw mr-2 text-[#00ADB5]"></i>{{ $history->event_date }}</p>
                    </div>

                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-3">{{ __('messages.full_description') }}</h4>
                        <p class="text-gray-200 leading-relaxed whitespace-pre-wrap">{{ $history->description }}</p>
                    </div>

                    @if($history->images->isNotEmpty())
                        <h4 class="text-xl font-semibold mb-4">{{ __('messages.attached_images') }}</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($history->images as $image)
                                <div>
                                    <img class="h-auto max-w-full rounded-lg shadow-lg border-2 border-white/20" src="{{ asset('storage/' . $image->path) }}" alt="{{ __('messages.event_image_alt') }}">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400">{{ __('messages.no_images_attached') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
