<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('messages.article_details') }}:
            <span class="font-normal text-gray-300">{{ Str::limit($article->title, 50) }}</span>
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
        @if (session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ __('messages.success') }}: {{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ __('messages.error') }}: {{ session('error') }}</span>
            </div>
        @endif
    </div>
    
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- المحتوى الرئيسي --}}
                <div class="lg:col-span-2 bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-8">
                    <h3 class="text-3xl font-bold text-white">{{ $article->title }}</h3>
                    <div class="text-sm text-gray-400 mt-3">
                        <span>{{ __('messages.by_author') }}: 
                            <span class="font-medium text-gray-300">{{ $article->user->name }}</span>
                        </span> |
                        <span>{{ __('messages.in_category') }}: 
                            <span class="font-medium text-gray-300">{{ $article->category->name }}</span>
                        </span>
                    </div>
                    <hr class="my-6 border-white/20">
                    <div class="prose prose-lg dark:prose-invert max-w-none text-gray-300 leading-relaxed prose-headings:text-white prose-a:text-[#00ADB5] hover:prose-a:text-[#02C39A] prose-strong:text-white">
                        {!! $article->content !!}
                    </div>
                </div>

                {{-- الجانب الأيمن --}}
                <div class="space-y-8">

                    {{-- المعجبون --}}
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                        <h4 class="font-bold text-white mb-4 flex items-center">
                            <i class="fas fa-heart text-red-400 mr-3"></i>
                            {{ __('messages.likes_section') }} ({{ $article->likes->count() }}) 
                        </h4>
                        <ul class="space-y-3 max-h-48 overflow-y-auto pr-2">
                            @forelse ($article->likes as $user)
                                <li class="text-sm text-gray-300">{{ $user->name }}</li>
                            @empty
                                <p class="text-sm text-gray-400">{{ __('messages.no_likes_yet') }}</p>
                            @endforelse
                        </ul>
                    </div>

                    {{-- إعدادات المقال --}}
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                        <h4 class="font-bold text-white mb-4 flex items-center">
                            <i class="fas fa-cog text-gray-300 mr-3"></i>
                            {{ __('messages.article_settings') }}
                        </h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-300">{{ __('messages.comments_status') }}</p>
                                @if ($article->comments_enabled)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-300">
                                        <i class="fas fa-check-circle mr-1"></i> {{ __('messages.enabled') }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-300">
                                        <i class="fas fa-times-circle mr-1"></i> {{ __('messages.disabled') }}
                                    </span>
                                @endif
                            </div>

                            <form action="{{ route('admin.articles.toggleComments', $article) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:scale-105 
                                    {{ $article->comments_enabled ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }}">
                                    @if ($article->comments_enabled)
                                        <i class="fas fa-comment-slash"></i>
                                        {{ __('messages.disable') }}
                                    @else
                                        <i class="fas fa-comment"></i>
                                        {{ __('messages.enable') }}
                                    @endif
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- التعليقات --}}
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                        <h4 class="font-bold text-white mb-4 border-b border-white/20 pb-3 flex items-center">
                            <i class="fas fa-comments text-gray-300 mr-3"></i>
                            {{ __('messages.comments') }} ({{ $article->comments->count() }})
                        </h4>
                        <div class="space-y-6 max-h-96 overflow-y-auto pr-2">
                            @forelse ($article->comments as $comment)
                                <div class="flex items-start space-x-4 space-x-reverse" id="comment-{{ $comment->id }}">
                                    <img class="w-10 h-10 rounded-full object-cover border-2 border-white/30" 
                                         src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=283E51&color=fff' }}" 
                                         alt="{{ $comment->user->name }}">
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="font-semibold text-sm text-white">{{ $comment->user->name }}</span>
                                                <span class="text-xs text-gray-400 mr-2">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>
                                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('{{ __('messages.delete_confirmation') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-500 transition-colors" title="{{ __('messages.delete_comment') }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                        <p class="text-sm text-gray-300 mt-1 leading-relaxed">
                                            {{ $comment->body }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400 text-center py-4">{{ __('messages.no_comments_yet') }}</p>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
