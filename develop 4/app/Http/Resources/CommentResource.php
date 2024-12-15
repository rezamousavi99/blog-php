<?php

namespace App\Http\Resources;

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
            'comment_text' => $this->comment_text,
            'user_name' => $this->user->user_name,
            'created_at' => $this->created_at,
            'like_count' => $this->likes->count(),
            'is_liked_by_user' => auth()->check() ? $this->isLikedByUser(auth()->user()->id) : false,
        ];
    }
}
