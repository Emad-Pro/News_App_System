<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            تفاصيل المقال: {{ Str::limit($article->title, 50) }}
        </h2>
    </x-slot>
{{-- ▼▼ أضف هذا الجزء لعرض الإشعارات ▼▼ --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $article->title }}</h3>
                    <div class="text-sm text-gray-500 mt-2">
                        <span>بواسطة: {{ $article->user->name }}</span> |
                        <span>في فئة: {{ $article->category->name }}</span>
                    </div>
                    <hr class="my-4 dark:border-gray-600">
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $article->content !!}
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                        <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">
                            المعجبون بالمقال ({{ $article->likes->count() }})
                        </h4>
                        <ul class="space-y-2">
                            @forelse ($article->likes as $user)
                                <li class="text-sm text-gray-600 dark:text-gray-300">{{ $user->name }} - ({{ $user->email }})</li>
                            @empty
                                <p class="text-sm text-gray-500">لا يوجد معجبون بهذا المقال بعد.</p>
                            @endforelse
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
    <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-4 border-b dark:border-gray-700 pb-3">
        التعليقات ({{ $article->comments->count() }})
    </h4>
    <div class="space-y-5">
        @forelse ($article->comments as $comment)
            <div class="flex items-start space-x-4 space-x-reverse" id="comment-{{ $comment->id }}">
                <img class="w-10 h-10 rounded-full object-cover" 
                     src="{{ $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random' }}" 
                     alt="{{ $comment->user->name }}">
                
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا التعليق؟');">
                            @csrf
                            @method('DELETE')
<button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">
    حذف
</button>
                        </form>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                        {{ $comment->body }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 text-center py-4">لا توجد تعليقات على هذا المقال بعد.</p>
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
    .highlight-comment {
        background-color: #fef9c3; /* Tailwind's yellow-100 */
        border-right: 4px solid #f59e0b; /* Tailwind's amber-500 */
        transition: background-color 1.5s ease;
        padding: 1rem;
        margin: -1rem;
        border-radius: 8px;
    }
    .dark .highlight-comment {
        background-color: #3f3310; /* Darker yellow for dark mode */
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // تحقق من وجود hash في الرابط
        if (window.location.hash) {
            const commentId = window.location.hash.substring(1); // ex: #comment-123 -> comment-123
            const commentElement = document.getElementById(commentId);

            if (commentElement) {
                // انتقل بسلاسة إلى التعليق
                commentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });

                // أضف كلاس التظليل
                commentElement.classList.add('highlight-comment');

                // أزل كلاس التظليل بعد 3 ثوانٍ
                setTimeout(() => {
                    commentElement.classList.remove('highlight-comment');
                }, 3000);
            }
        }
    });
</script>
@endpush