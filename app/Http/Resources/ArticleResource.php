<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'featured_image_url' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,

            // This is the new field
            'comments_enabled' => (bool) $this->comments_enabled,

            'status' => $this->status,
            'views_count' => $this->views_count,
            'published_at' => $this->published_at?->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),

            // Include related data if loaded
            'author' => new UserResource($this->whenLoaded('user')),
            'category' => new CategoryResource($this->whenLoaded('category')),

            // Include counts
            'likes_count' => $this->likes_count ?? $this->likes->count(),
            'comments_count' => $this->comments_count ?? $this->comments->count(),
        ];
    }
}