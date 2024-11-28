<?php

namespace App\Http\Resources\V1\Dashboard\Blog;

use App\Http\Resources\V1\App\Blog\CommentResource;
use App\Http\Resources\V1\App\Blog\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogAdminCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}
