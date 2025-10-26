<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // دالة لعرض قائمة المقالات
    public function index()
    {
        // جلب المقالات المنشورة فقط، مع الفئة والكاتب، وترتيبها من الأحدث للأقدم
        // استخدام paginate() ضروري للـ API لتقسيم النتائج على صفحات
        $articles = Article::where('status', 'published')
                            ->with('category', 'user') // Eager Loading لتحسين الأداء
                            ->latest('published_at')
                            ->paginate(10); // 10 مقالات في كل صفحة

        return response()->json($articles);
    }

    // دالة لعرض مقال واحد
public function show(Article $article)
{
    // زيادة عدد المشاهدات
    $article->increment('views_count');

    // إرجاع بيانات المقال مع تحميل كل العلاقات بما فيها الوسائط الجديدة
    return response()->json(
        $article->load('category', 'user', 'tags', 'media') // <-- أضفنا 'media' هنا
    );
}
}
