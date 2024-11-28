<?php

namespace App\Http\Resources\V1\Dashboard\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'blog_id' => $this->blog_id,
            'is_blog' => $this->blog?->is_blog,
            'user' => $this->user?->name,
            'user_id' => $this->user?->id,
            'user_type' => $this->user?->type,
            'user_image' => $this->user->image ?? null,
            'user_sub_category' => $this->user?->subcategory?->first()?->t('name'),
            'comment' => $this->comment ?? null,
            'comment_image' => $this->image ?? null,
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
