<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostSummaryResource extends JsonResource
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
            'excerpt' => $this->excerpt,
            'slug' => $this->slug,
            'content' => $this->content,
            'user_name' => $this->user->user_name,
            'created_at' => $this->created_at,
            'tags' => $this->tags->pluck('caption'),
            'like_count' => $this->likes->count(),
            'is_liked_by_user' => auth()->check() ? $this->isLikedByUser(auth()->user()->id) : false,
            'comments' => CommentResource::collection($this->comments->take(2)), // Show only 2 comments
        ];
    }
}
