<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('messages.manage_categories') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#00ADB5] hover:bg-[#02C39A] text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                {{ __('messages.add_category') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
        @if (session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-6 text-white">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="border-b border-white/20">
                                @php
    $isRtl = app()->getLocale() === 'ar';
    $marginClass = $isRtl ?  'text-right':'text-left';
@endphp

                                <tr>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">{{ __('messages.name') }}</th>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">Slug</th>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">{{ __('messages.articles_count') }}</th>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse ($categories as $category)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $category->slug }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $category->articles_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-6">
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-400 hover:text-blue-300" title="{{ __('messages.edit_category') }}">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete_category') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-500" title="{{ __('messages.delete_category') }}">
                                                        <i class="fas fa-trash-alt fa-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 whitespace-nowrap text-sm text-gray-400 text-center">
                                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                                            <p>{{ __('messages.no_categories_found') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
