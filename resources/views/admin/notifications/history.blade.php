<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            سجل الإشعارات
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                <div class="p-6 text-white">
                    <div class="space-y-4">
                        @forelse ($notifications as $notification)
                            {{-- تم تحسين تصميم كل إشعار --}}
                            <a href="{{ route('admin.articles.show', $notification->data['article_slug']) }}#comment-{{ $notification->data['comment_id'] }}"
                               class="block p-4 rounded-lg transition duration-300 hover:bg-white/10 {{ $notification->read_at ? 'opacity-70' : 'border-r-4 border-[#00ADB5]' }}">
                                
                                <div class="flex items-start gap-4">
                                    <div class="text-xl text-gray-400 pt-1">
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-white">
                                            <span class="font-bold">{{ $notification->data['user_name'] }}</span>
                                            علّق على مقال: "{{ $notification->data['article_title'] }}"
                                        </p>
                                        <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if(!$notification->read_at)
                                        <span class="text-xs font-bold text-[#00ADB5]">جديد</span>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="text-center text-gray-400 py-12">
                                <i class="fas fa-bell-slash fa-3x mb-3"></i>
                                <p>لا يوجد إشعارات لعرضها.</p>
                            </div>
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