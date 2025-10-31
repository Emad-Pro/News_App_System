<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('messages.edit_category') }}: <span class="font-normal text-gray-300">{{ $category->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-8 text-white">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-300 mb-1">{{ __('messages.category_name') }}</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                   class="w-full rounded-lg border-gray-500 bg-gray-900/50 text-white focus:border-[#00ADB5] focus:ring-2 focus:ring-[#00ADB5] transition">
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-sm" />
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-[#00ADB5] text-white font-semibold rounded-lg hover:bg-[#02C39A] shadow-md transition duration-300 transform hover:scale-105">
                                <i class="fas fa-save"></i>
                                {{ __('messages.update_category') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
