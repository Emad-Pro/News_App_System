<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleMedia; // <-- تم التغيير إلى هذا الموديل
use App\Http\Resources\MediaVideoResource; // <-- تم التغيير إلى هذا الريسورس

class UserArticleVideoController extends Controller
{
    /**
     * جلب كل الفيديوهات المرفوعة من قبل الأدمن
     */
    public function index()
    {
        // 1. ابحث في جدول الوسائط عن الملفات من نوع 'video' فقط
        $videos = ArticleMedia::where('type', 'video')
            // 2. تأكد من أن المقال المرتبط بالفيديو يعود لمستخدم 'admin'
            ->whereHas('article.user', function ($query) {
                $query->where('role', 'admin'); // يفترض وجود عمود 'role' في جدول users
            })
            ->latest() // لجلب أحدث الفيديوهات أولًا
            ->get();

        // 3. استخدم ה-Resource الجديد لتنسيق البيانات
        return MediaVideoResource::collection($videos);
    }
}