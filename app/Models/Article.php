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
        'comments_enabled',
    ];

    /**
     * The attributes that should be cast to native types.
     * هذا يضمن أن 'comments_enabled' ستكون دائماً true/false
     * وأن 'published_at' سيكون دائماً كائن تاريخ (Carbon).
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
        'comments_enabled' => 'boolean',
    ];

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