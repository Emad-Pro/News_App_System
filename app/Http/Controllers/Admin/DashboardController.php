<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. الإحصائيات العامة (للبطاقات) ---
        $userCount = User::count();
        $articleCount = Article::count();
        $commentCount = Comment::count();
        $totalViews = Article::sum('views_count');

        // --- 2. بيانات الرسم البياني الأول: أبرز المقالات ---
        $topArticles = Article::withCount(['likes', 'comments'])
            ->orderByDesc('likes_count')
            ->orderByDesc('comments_count')
            ->limit(5) // جلب أفضل 5 مقالات تفاعلاً
            ->get();

        $articleLabels = $topArticles->pluck('title')->map(fn($title) => mb_strimwidth($title, 0, 25, "..."));
        $articleLikesData = $topArticles->pluck('likes_count');
        $articleCommentsData = $topArticles->pluck('comments_count');

        // --- 3. بيانات الرسم البياني الثاني: نمو المستخدمين ---
        $period = CarbonPeriod::create(now()->subDays(6), now());
        $userStats = User::where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date');
            
        $userChartLabels = [];
        $userChartData = [];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $userChartLabels[] = $date->translatedFormat('D, M j'); 
            $userChartData[] = $userStats[$formattedDate] ?? 0;
        }
        
        // --- 4. بيانات القوائم السريعة ---
        $latestArticles = Article::with('user')->latest()->take(5)->get();
        $latestComments = Comment::with(['user', 'article'])->latest()->take(5)->get();

        return view('admin.dashboard', [
            // الإحصائيات العامة
            'userCount' => $userCount, 
            'articleCount' => $articleCount, 
            'commentCount' => $commentCount, 
            'totalViews' => $totalViews,

            // بيانات المخططات (محولة لـ JSON)
            'articleLabels' => json_encode($articleLabels),
            'articleLikesData' => json_encode($articleLikesData),
            'articleCommentsData' => json_encode($articleCommentsData),
            'userChartLabels' => json_encode($userChartLabels),
            'userChartData' => json_encode($userChartData),
            
            // بيانات القوائم السريعة
            'latestArticles' => $latestArticles,
            'latestComments' => $latestComments,
        ]);
    }
}