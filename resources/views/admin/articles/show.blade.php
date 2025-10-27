<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            تفاصيل المقال: <span class="font-normal text-gray-300">{{ Str::limit($article->title, 50) }}</span>
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6">
        @if (session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-8">
                    <h3 class="text-3xl font-bold text-white">{{ $article->title }}</h3>
                    <div class="text-sm text-gray-400 mt-3">
                        <span>بواسطة: <span class="font-medium text-gray-300">{{ $article->user->name }}</span></span> |
                        <span>في فئة: <span class="font-medium text-gray-300">{{ $article->category->name }}</span></span>
                    </div>
                    <hr class="my-6 border-white/20">
                    {{-- تم تحسين أنماط عرض محتوى المقال --}}
                    <div class="prose prose-lg dark:prose-invert max-w-none text-gray-300 leading-relaxed prose-headings:text-white prose-a:text-[#00ADB5] hover:prose-a:text-[#02C39A] prose-strong:text-white">
                        {!! $article->content !!}
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                        <h4 class="font-bold text-white mb-4 flex items-center">
                            <i class="fas fa-heart text-red-400 mr-3"></i>
                            المعجبون بالمقال  ({{ $article->likes->count() }}) 
                        </h4>
                        <ul class="space-y-3 max-h-48 overflow-y-auto pr-2">
                            @forelse ($article->likes as $user)
                                <li class="text-sm text-gray-300">{{ $user->name }}</li>
                            @empty
                                <p class="text-sm text-gray-400">كن أول من يعجب بهذا المقال.</p>
                            @endforelse
                        </ul>
                    </div>

                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                        <h4 class="font-bold text-white mb-4 border-b border-white/20 pb-3 flex items-center">
                            <i class="fas fa-comments text-gray-300 mr-3"></i>
                            التعليقات ({{ $article->comments->count() }})
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
                                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التعليق؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-500 transition-colors" title="حذف التعليق">
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
                                <p class="text-sm text-gray-400 text-center py-4">لا توجد تعليقات على هذا المقال بعد.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<style>
    /* تم تعديل ستايل تظليل التعليق ليتناسب مع الثيم المظلم */
    .highlight-comment {
        background-color: rgba(0, 173, 181, 0.15); /* لون فيروزي شبه شفاف */
        border-right: 4px solid #00ADB5;
        transition: background-color 1.5s ease;
        padding: 1rem;
        margin: -1rem; /* لتعويض الـ padding */
        border-radius: 8px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.hash) {
            const commentId = window.location.hash.substring(1);
            const commentElement = document.getElementById(commentId);

            if (commentElement) {
                commentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                commentElement.classList.add('highlight-comment');
                setTimeout(() => {
                    commentElement.classList.remove('highlight-comment');
                }, 3500); // زيادة المدة قليلاً
            }
        }
    });
</script>
@endpush