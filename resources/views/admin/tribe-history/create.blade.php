<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('messages.add_new_event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-8 text-white">
                    <form action="{{ route('admin.histories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-300">{{ __('messages.event_title') }}</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                   class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                        </div>

                        <div class="mb-6">
                            <label for="event_date" class="block mb-2 text-sm font-medium text-gray-300">{{ __('messages.date') }}</label>
                            <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}" required
                                   class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                        </div>

                        <div class="mb-6">
                            <label for="images" class="block mb-2 text-sm font-medium text-gray-300">{{ __('messages.event_images') }}</label>
                            <input type="file" id="images" name="images[]" multiple
                                   class="block w-full text-sm text-gray-400 border rounded-lg cursor-pointer bg-gray-900/50 border-gray-500">
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-300">{{ __('messages.full_description') }}</label>
                            <textarea id="description" name="description" rows="6"
                                      class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition"
                                      required>{{ old('description') }}</textarea>
                        </div>

                        <div class="flex justify-end gap-4 mt-8">
                            <a href="{{ route('admin.histories.index') }}" class="px-5 py-2.5 text-sm font-medium text-white bg-gray-600/50 rounded-lg hover:bg-gray-500/50 transition">
                                {{ __('messages.cancel') }}
                            </a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-[#00ADB5] hover:bg-[#02C39A] rounded-lg transition">
                                {{ __('messages.save_event') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
