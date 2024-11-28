<?php

namespace App\Http\Resources\V1\App\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogGeneralResource extends JsonResource
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
            'content' => $this->content,
            'date' => $this->created_at->format('Y-m-d g:i'),
            'comments_count' => $this->comments->count(),
            'user' => $this->user?->name,
            'user_image' => $this->user?->image ?? null,
            'user_id' => $this->user?->id,
            'user_type' => $this->user?->type,
            'rate_users' => $this->user->averageRate,
            'images' => $this->images?->first()?->image,
        ];
    }
}
