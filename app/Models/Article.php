<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 1. لا تنسَ استدعاء الدالة المساعدة asset()، وهي متاحة تلقائيًا، لكن التنبيه عليها جيد.

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'status',
        'published_at',
        'comments_enabled',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'comments_enabled' => 'boolean',
    ];

    // 2. طلب إضافة الحقل الوهمي 'image_url' إلى مصفوفة الـ JSON
    protected $appends = ['image_url'];

    // 3. تعريف الـ Accessor (الذي ينشئ الرابط الكامل)
    public function getImageUrlAttribute()
    {
        if ($this->featured_image) {
            // يقوم بدمج رابط الموقع الأساسي مع مسار الصورة
            // مثال: https://ea.run.place/storage/articles/featured/xyz.png
            return asset('storage/' . $this->featured_image);
        }
        
        // يمكنك إرجاع رابط صورة افتراضية في حال عدم وجود صورة
        return null; 
    }

    /**
     * Get the category that the article belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments for the article.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The users that have liked the article.
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'article_likes');
    }

    /**
     * Get the user (author) that the article belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the media gallery for the article.
     */
    public function media()
    {
        return $this->hasMany(ArticleMedia::class);
    }

    /**
     * The tags that belong to the article.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}