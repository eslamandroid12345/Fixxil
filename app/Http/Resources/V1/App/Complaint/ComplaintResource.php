<?php

namespace App\Http\Resources\V1\App\Complaint;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
                ];
    }
}
