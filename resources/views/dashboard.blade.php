<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">{{ __('Users') }}</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $userCount }}</p>
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                    <i class="fas fa-users fa-lg"></i>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">{{ __('Articles') }}</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $articleCount }}</p>
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                    <i class="fas fa-newspaper fa-lg"></i>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">{{ __('Comments') }}</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ $commentCount }}</p>
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                    <i class="fas fa-comments fa-lg"></i>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-5 flex items-center justify-between transition duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="text-sm font-medium text-gray-300">{{ __('Total Views') }}</h3>
                    <p class="text-3xl font-bold text-white mt-1">{{ number_format($totalViews) }}</p>
                </div>
                <div class="bg-[#00ADB5]/20 text-[#00ADB5] p-3 rounded-full">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
            </div>

        </div>
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            <div class="lg:col-span-3 bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4">{{ __('Top Performing Articles') }}</h3>
                <canvas id="articlesChart" class="max-h-80"></canvas>
            </div>

            <div class="lg:col-span-2 bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4">{{ __('New Users (Last 7 Days)') }}</h3>
                <canvas id="usersChart" class="max-h-80"></canvas>
            </div>

        </div>
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4">{{ __('Latest Articles') }}</h3>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse ($latestArticles as $article)
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                            <div>
                                <a href="{{ route('admin.articles.show', $article) }}" class="font-medium text-white hover:text-[#00ADB5] transition">{{ Str::limit($article->title, 40) }}</a>
                                <p class="text-sm text-gray-300">{{ __('By') }} {{ $article->user->name }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $article->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center">{{ __('No articles found.') }}</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg border border-white/20 p-6">
                <h3 class="text-lg font-semibold text-white mb-4">{{ __('Latest Comments') }}</h3>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse ($latestComments as $comment)
                        <div class="p-3 bg-white/5 rounded-lg">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-white">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-300">{{ Str::limit($comment->body, 80) }}</p>
                            <a href="{{ route('admin.articles.show', $comment->article) }}#comment-{{$comment->id}}" class="text-xs text-[#00ADB5] hover:underline mt-1 inline-block">{{ __('View on article') }}</a>
                        </div>
                    @empty
                        <p class="text-gray-400 text-center">{{ __('No comments found.') }}</p>
                    @endforelse
                </div>
            </div>

        </div>
        </div>
</x-app-layout>
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- إعدادات الألوان لتتناسب مع الثيم ---
    const textColor = 'rgba(255, 255, 255, 0.7)';
    const gridColor = 'rgba(255, 255, 255, 0.1)';
    const tooltipColor = 'rgba(0, 0, 0, 0.8)';

    // --- 1. إعداد مخطط أبرز المقالات (Bar Chart) ---
    const ctxArticles = document.getElementById('articlesChart')?.getContext('2d');
    if (ctxArticles) {
        new Chart(ctxArticles, {
            type: 'bar',
            data: {
                labels: {!! $articleLabels !!},
                datasets: [
                    {
                        label: '{{ __('Likes') }}',
                        data: {!! $articleLikesData !!},
                        backgroundColor: 'rgba(0, 173, 181, 0.6)', // Teal
                        borderColor: 'rgba(0, 173, 181, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    },
                    {
                        label: '{{ __('Comments') }}',
                        data: {!! $articleCommentsData !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.4)', // Lighter Teal
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { labels: { color: textColor } },
                    tooltip: { backgroundColor: tooltipColor }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor, precision: 0 },
                        grid: { color: gridColor }
                    },
                    x: {
                        ticks: { color: textColor },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // --- 2. إعداد مخطط نمو المستخدمين (Line Chart) ---
    const ctxUsers = document.getElementById('usersChart')?.getContext('2d');
    if (ctxUsers) {
        new Chart(ctxUsers, {
            type: 'line',
            data: {
                labels: {!! $userChartLabels !!},
                datasets: [{
                    label: '{{ __('New Users') }}',
                    data: {!! $userChartData !!},
                    backgroundColor: 'rgba(0, 173, 181, 0.2)',
                    borderColor: '#00ADB5',
                    borderWidth: 2,
                    pointBackgroundColor: '#00ADB5',
                    pointRadius: 4,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: { backgroundColor: tooltipColor }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor, precision: 0 },
                        grid: { color: gridColor }
                    },
                    x: {
                        ticks: { color: textColor },
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endpush