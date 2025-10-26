<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike(Request $request, Article $article)
    {
        // الحصول على المستخدم الحالي
        $user = $request->user();

        // toggle تقوم بإضافة أو حذف الربط تلقائيًا
        $article->likes()->toggle($user->id);

        return response()->json([
            'message' => 'Success',
            'likes_count' => $article->likes()->count() // إرجاع العدد الجديد للإعجابات
        ]);
    }
}