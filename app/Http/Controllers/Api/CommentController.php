<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Events\NewCommentNotification;

class CommentController extends Controller
{
    // دالة لعرض كل التعليقات على مقال
    public function index(Article $article)
    {
        $comments = $article->comments()
                            ->with('user:id,name,avatar') // جلب بيانات كاتب التعليق لتحسين الأداء
                            ->latest()
                            ->paginate(15);

        return response()->json($comments);
    }

    // دالة لتخزين تعليق جديد
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'body' => 'required|string|max:2500',
        ]);

        $comment = $article->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $request->body,
        ]);
        $admin = User::where('role', 'admin')->first();
    if ($admin) {
        $admin->notify(new NewCommentNotification($comment));
    }
        
        // إرجاع التعليق الجديد مع بيانات كاتبه
        return response()->json($comment->load('user:id,name,avatar'), 201); // 201 = Created
    }
}