<?php

namespace App\Http\Resources\V1\Dashboard\Blog;

use App\Http\Resources\V1\App\Blog\CommentResource;
use App\Http\Resources\V1\App\Blog\ImageResource;
use Carbon\Carbon;
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
            'category' => $this->category->t('name'),
            'title' => $this->title,
            'content' => $this->content,
            'is_published' => $this->is_published,
            // 'user' => $this->user?->name ? $this->user?->name : 'Admin',
            'user' => $this->user ? $this->user?->name : $this->manager?->name,
            'images' => BlogImageResource::collection($this->images),
            'date' => $this->created_at->format('Y-m-d g:i'),
            'comments_count' => $this->comments->count(),
            // 'user_image' => $this->user?->image ?? null,
            'user_image' => $this->user ? $this->user?->image : $this->manager?->image,
            'user_id' => $this->user?->id,
            'user_type' => $this->user?->type,
            'user_sub_category' => $this->user?->subcategory?->first()?->t('name') ,
            'rateusers' => $this->user?->avarage_rate,
            'comments' => CommentResource::collection($this->comments),
            'created_at' => Carbon::parse($this->created_at)->format('d M Y h:ia')
        ];
    }
}
