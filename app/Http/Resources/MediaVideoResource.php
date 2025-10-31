<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediaVideoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // '$this' هنا يشير إلى موديل ArticleMedia
        return [
            'video_id' => $this->id,
            'video_url' => Storage::url($this->path), // تحويل المسار إلى رابط كامل
            'article' => [
                'id' => $this->article->id,
                'title' => $this->article->title,
                'slug' => $this->article->slug,
            ]
        ];
    }
}