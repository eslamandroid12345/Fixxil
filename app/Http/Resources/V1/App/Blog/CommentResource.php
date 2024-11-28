<?php

namespace App\Http\Resources\V1\App\Blog;

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
            'user' => $this->user?->name,
            'user_id' => $this->user?->id,
            'user_type' => $this->user?->type,
            'user_image' => $this->user->image ?? null,
            'user_sub_category' => $this->user?->subcategory?->first()?->t('name') ,
            'comment' => $this->comment ?? null,
            'comment_image' => $this->image ?? null,
            'date' => $this->created_at->format('Y-m-d g:i'),
        ];
    }
}
