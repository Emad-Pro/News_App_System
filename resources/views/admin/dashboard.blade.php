<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('لوحة التحكم الرئيسية') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد المستخدمين</h3>
                <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $userCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد المقالات</h3>
                <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $articleCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">عدد التعليقات</h3>
                <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ $commentCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                <h3 class="text-sm text-gray-500 dark:text-gray-400">إجمالي المشاهدات</h3>
                <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-1">{{ number_format($totalViews) }}</p>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">المستخدمون الجدد (آخر 7 أيام)</h3>
                <div>
                    <canvas id="usersChart"></canvas>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">أحدث المقالات</h4>
                    <ul class="space-y-3">
                        @forelse($latestArticles as $article)
                            <li class="text-sm">
                                <a href="{{ route('admin.articles.show', $article) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ Str::limit($article->title, 40) }}
                                </a>
                                <span class="block text-xs text-gray-500">بواسطة {{ $article->user->name }}</span>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500">لا توجد مقالات بعد.</p>
                        @endforelse
                    </ul>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">أحدث التعليقات</h4>
                    <ul class="space-y-3">
                        @forelse($latestComments as $comment)
                             <li class="text-sm">
                                <p class="text-gray-700 dark:text-gray-300">{{ Str::limit($comment->body, 50) }}</p>
                                <a href="{{ route('admin.articles.show', $comment->article) }}" class="text-xs text-indigo-500 hover:underline">
                                    بواسطة {{ $comment->user->name }} على مقال "{{ Str::limit($comment->article->title, 20) }}"
                                </a>
                            </li>
                        @empty
                            <p class="text-sm text-gray-500">لا توجد تعليقات بعد.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('usersChart').getContext('2d');
            const usersChart = new Chart(ctx, {
                type: 'line', // نوع المخطط: خطي
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'مستخدم جديد',
                        data: {!! json_encode($chartData) !!},
                        borderColor: 'rgba(79, 70, 229, 1)',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    responsive: true
                }
            });
        });
    </script>
</x-app-layout>