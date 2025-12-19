<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // =========================================================
    // 1. عرض المقالات (حل مشكلة ظهور اللايكات) 🚀
    // =========================================================
    public function index(Request $request)
    {
        // معرفة المستخدم الحالي (إن وجد)
        $user = $request->user('sanctum');

        $articles = Article::where('status', 'published')
            ->with(['category', 'user', 'media']) // تحميل بيانات الكاتب والقسم والصور
            
            // 🔥 1. إضافة حقل 'likes_count' (عدد اللايكات)
            ->withCount('likes')

            // 🔥 2. إضافة حقل 'is_liked' (هل أعجبني؟ true/false)
            // نستخدم دالة when لضمان عدم حدوث خطأ لو كان المستخدم زائر
            ->when($user, function ($query) use ($user) {
                $query->withExists(['likes as is_liked' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                }]);
            })
            
            ->latest('published_at')
            ->paginate(10);

        return response()->json($articles);
    }

    // =========================================================
    // 2. زر اللايك (حل مشكلة عدم التحديث) ⚡
    // =========================================================
    public function toggleLike(Request $request, Article $article)
    {
        $user = $request->user();

        // عملية التبديل (Toggle):
        // إذا كان موجوداً يحذفه، وإذا لم يكن موجوداً يضيفه
        // النتيجة مصفوفة تخبرنا ماذا حدث ['attached' => [], 'detached' => []]
        $changes = $article->likes()->toggle($user->id);

        // معرفة الحالة الجديدة
        // إذا كانت attached ممتلئة، يعني "تمت الإضافة" (أصبح أحمر ❤️)
        $isLiked = count($changes['attached']) > 0;

        // الرد الاحترافي (نرسل العدد الجديد والحالة الجديدة فقط)
        return response()->json([
            'status' => true,
            'message' => $isLiked ? 'تم الإعجاب' : 'تم إلغاء الإعجاب',
            
            // ✅ هذه البيانات هي التي ستستخدمها في فلاتر لتحديث الواجهة محلياً
            'is_liked' => $isLiked, 
            'likes_count' => $article->likes()->count() 
        ]);
    }

    // عرض مقال واحد (نفس منطق الـ index)
    public function show(Request $request, Article $article)
    {
        $user = $request->user('sanctum');
        $article->increment('views_count');

        $article->load(['category', 'user', 'tags', 'media'])
                ->loadCount('likes'); // تحميل العدد

        // تحديد حالة is_liked يدوياً للمقال الفردي
        $article->is_liked = $user ? $article->likes()->where('user_id', $user->id)->exists() : false;

        return response()->json($article);
    }
}