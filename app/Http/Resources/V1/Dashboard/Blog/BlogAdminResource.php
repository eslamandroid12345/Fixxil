<?php

namespace App\Http\Resources\V1\Dashboard\Blog;

use App\Http\Resources\V1\App\Blog\CommentResource;
use App\Http\Resources\V1\App\Blog\ImageResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogAdminResource extends JsonResource
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
            'category' => $this->category->t('name'),
            'category_id' => $this->category_id,
            'is_published' => $this->is_published,
            'manager' => $this->manager->name,
            'images' => BlogImageResource::collection($this->images),
            'date' => $this->created_at->format('Y-m-d H:i'),
            'comments_count' => $this->comments->count(),
            'manager_image' => $this->manager->image ?? null,
            'manager_id' => $this->manager?->id,
            'comments' => CommentResource::collection($this->comments),
            'created_at' => Carbon::parse($this->created_at)->format('d M Y h:ia')
        ];
    }
}
