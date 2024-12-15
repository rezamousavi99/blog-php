<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Paginate comments for single post view
        $paginatedComments = $this->comments()->paginate($request->input('per_page_comments', 5));

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'slug' => $this->slug,
            'user_name' => $this->user->user_name,
            'created_at' => $this->created_at,
            'tags' => $this->tags->pluck('caption'),
            'like_count' => $this->likes->count(),
            'is_liked_by_user' => auth()->check() ? $this->isLikedByUser(auth()->user()->id) : false,

            // Paginated comments
            'comments' => [
                'data' => CommentResource::collection($paginatedComments->items()),  // Format comments
                'pagination' => [
                    'total' => $paginatedComments->total(),
                    'count' => $paginatedComments->count(),
                    'per_page' => $paginatedComments->perPage(),
                    'current_page' => $paginatedComments->currentPage(),
                    'total_pages' => $paginatedComments->lastPage(),
                    'next_page_url' => $paginatedComments->nextPageUrl(),
                    'prev_page_url' => $paginatedComments->previousPageUrl(),
                ]
            ]
        ];
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
