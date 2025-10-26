<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification; // <-- استخدم هذا
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewCommentNotification extends Notification implements ShouldBroadcast // <-- طبق الواجهة
{
    use Queueable;

    public $comment;

    public function __construct(Comment $comment)
    {
        // نحمل العلاقات التي سنحتاجها في الإشعار
        $this->comment = $comment->load('user:id,name', 'article:id,title,slug');
    }

    // تحديد القنوات التي سيتم الإرسال إليها (قاعدة البيانات والبث الفوري)
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    // تحديد شكل البيانات التي ستُحفظ في قاعدة البيانات
    public function toDatabase(object $notifiable): array
    {
        return [
            'comment_id' => $this->comment->id, // <-- أضف هذا السطر
            'user_name' => $this->comment->user->name,
            'article_title' => $this->comment->article->title,
            'article_slug' => $this->comment->article->slug,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'comment_id' => $this->comment->id, // <-- وأضف هذا السطر هنا أيضًا
            'user_name' => $this->comment->user->name,
            'article_title' => $this->comment->article->title,
            'article_slug' => $this->comment->article->slug,
        ]);
    }
}