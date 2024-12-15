<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostTag>
 */
class PostTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\PostTag::class;

    public function definition()
    {
        // Retrieve existing post IDs and tag IDs
        $postIds = Post::pluck('id');
        $tagIds = Tag::pluck('id');

        return [
            'post_id' => $this->faker->randomElement($postIds),
            'tag_id' => $this->faker->randomElement($tagIds),
        ];
    }
}
