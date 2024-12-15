<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\PostResource;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Manually control the structure
        return [
            'data' => [
                'posts' => PostSummaryResource::collection($this->collection),  // Transformed posts
                'pagination' => [
                    'total' => $this->total(),
                    'count' => $this->count(),
                    'per_page' => $this->perPage(),
                    'current_page' => $this->currentPage(),
                    'total_pages' => $this->lastPage(),
                    'next_page_url' => $this->nextPageUrl(),
                    'prev_page_url' => $this->previousPageUrl(),
                    'first_page_url' => $this->url(1),
                    'last_page_url' => $this->url($this->lastPage()),
                ],
            ]
        ];
    }

    public function toResponse($request)
    {
        return JsonResource::toResponse($request);
    }
}
