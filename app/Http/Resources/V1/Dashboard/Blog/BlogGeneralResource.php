<?php

namespace App\Http\Resources\V1\Dashboard\Blog;

use Carbon\Carbon;
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
            'category' => $this->category->t('name'),
            'title' => $this->whenNotNull($this->title),
            'content' => $this->whenNotNull($this->content),
            'is_published' => $this->is_published,
            'user' => $this->user?->name,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y h:ia')
        ];
    }
}
