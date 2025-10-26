<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment; // <-- أضف هذا
use Illuminate\Http\Request;

class CommentController extends Controller
{
public function destroy($id)
    {
        // 1. نبحث عن التعليق يدويًا باستخدام الـ ID
        $comment = Comment::find($id);

        // 2. ✨ هذا هو الجزء الأهم: التحقق من وجود التعليق قبل محاولة حذفه
        if (!$comment) {
            // إذا لم يكن التعليق موجودًا، ارجع برسالة خطأ
            return back()->with('error', 'هذا التعليق غير موجود أو تم حذفه بالفعل.');
        }

        // 3. إذا كان التعليق موجودًا، قم بحذفه
        $comment->delete();

        // 4. ارجع برسالة نجاح
        return back()->with('success', 'تم حذف التعليق بنجاح.');
    }
}