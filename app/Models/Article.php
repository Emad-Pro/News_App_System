<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'content',
        'featured_image',
        'status',
        'published_at',
    ];

    /**
     * Get the category that the article belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
{
    // مقال واحد يمكن أن يُعجب به عدة مستخدمين
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