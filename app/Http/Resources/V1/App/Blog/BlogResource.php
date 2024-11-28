<?php

namespace App\Http\Resources\V1\App\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'user' => $this->user ? $this->user?->name : $this->manager?->name,
            'user_id' => $this->user?->id,
            'user_type' => $this->user?->type,
            'user_image' => $this->user ? $this->user?->image : $this->manager?->image,
            'user_sub_category' => $this->user?->subcategory?->first()?->t('name') ,
            'rateusers' => $this->user?->avarage_rate,
            'comments' => CommentResource::collection($this->comments),
            'images' => ImageResource::collection($this->images),
        ];
    }
}
