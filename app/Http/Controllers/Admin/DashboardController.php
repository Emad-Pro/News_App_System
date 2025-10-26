<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- أضف هذا
use Carbon\Carbon;                   // <-- وهذا أيضًا

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. الإحصائيات العامة (للبطاقات) ---
        $userCount = User::count();
        $articleCount = Article::count();
        $commentCount = Comment::count();
        $totalViews = Article::sum('views_count');

        // --- 2. بيانات المخطط البياني (نمو المستخدمين آخر 7 أيام) ---
        $usersPerDay = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->pluck('count', 'date');

        // تجهيز البيانات لـ Chart.js
        $chartLabels = $usersPerDay->keys()->map(function ($date) {
            return Carbon::parse($date)->format('D'); // ex: Sat
        });
        $chartData = $usersPerDay->values();

        // --- 3. بيانات القوائم السريعة ---
        $latestArticles = Article::with('user')->latest()->take(5)->get();
        $latestComments = Comment::with('user', 'article')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'userCount', 
            'articleCount', 
            'commentCount', 
            'totalViews',
            'chartLabels',
            'chartData',
            'latestArticles',
            'latestComments'
        ));
    }
}