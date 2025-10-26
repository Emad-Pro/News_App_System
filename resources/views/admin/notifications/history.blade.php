<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            سجل الإشعارات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="space-y-4">
                        @forelse ($notifications as $notification)
                            {{-- الرابط الآن يحتوي على slug المقال ومعرف التعليق --}}
                            <a href="{{ route('admin.articles.show', $notification->data['article_slug']) }}@if(isset($notification->data['comment_id']))#comment-{{ $notification->data['comment_id'] }}@endif"
   class="block p-4 rounded-lg transition {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700/50' : 'bg-indigo-50 dark:bg-indigo-900/50' }}">

                                
                                <p class="font-semibold text-gray-800 dark:text-gray-200">
                                    <span class="font-bold">{{ $notification->data['user_name'] }}</span>
                                    علّق على مقال: "{{ $notification->data['article_title'] }}"
                                </p>
                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                        @empty
                            <p class="text-center text-gray-500 py-8">لا يوجد إشعارات لعرضها.</p>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>