<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryStoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'story_date' => $this->story_date?->format('Y-m-d'), // صيغة التاريخ
        ];
    }
}