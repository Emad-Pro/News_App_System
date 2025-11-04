<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('messages.manage_users') }}
            </h2>

            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#00ADB5] hover:bg-[#02C39A] text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                <i class="fas fa-user-plus"></i>
                {{ __('messages.add_new_user') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-6 text-white">
@php
    $isRtl = app()->getLocale() === 'ar';
    $marginClass = $isRtl ?  'text-right':'text-left';
@endphp

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="border-b border-white/20">
                                <tr>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.user') }}
                                    </th>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.phone') }}
                                    </th>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.status') }}
                                    </th>
                                    <th class="px-6 py-3 {{$marginClass}} text-xs font-medium text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.actions') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-white/10">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=283E51&color=fff' }}"
                                                        alt="{{ $user->name }}">
                                                </div>
@php
    $isRtl = app()->getLocale() === 'ar';
    $marginClass = $isRtl ?  'mr-4':'ml-4';
@endphp

<div class="{{ $marginClass }}">
    <div class="text-sm font-medium text-white">{{ $user->name }}</div>
    <div class="text-sm text-gray-400">{{ $user->email }}</div>
</div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $user->phone ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $user->status === 'active' ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                                                {{ $user->status === 'active' ? __('messages.active') : __('messages.banned') }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-6">
                                                <!-- <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="text-blue-400 hover:text-blue-300" 
                                                   title="{{ __('messages.edit_user') }}">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </a> -->

                                                <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="{{ $user->status === 'active' ? 'text-yellow-400 hover:text-yellow-300' : 'text-green-400 hover:text-green-300' }}"
                                                        title="{{ $user->status === 'active' ? __('messages.ban_user') : __('messages.activate_user') }}">
                                                        <i class="fas {{ $user->status === 'active' ? 'fa-user-slash' : 'fa-user-check' }} fa-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 whitespace-nowrap text-sm text-gray-400 text-center">
                                            <i class="fas fa-users-slash fa-3x mb-3"></i>
                                            <p>{{ __('messages.no_users_found') }}</p>
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
