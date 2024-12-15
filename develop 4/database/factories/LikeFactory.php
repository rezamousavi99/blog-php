<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Randomly choose between 'Post' and 'Comment'
        $likeableType = $this->faker->randomElement([Post::class, Comment::class]);

        // Get a random ID from either the Post or Comment table
        $likeableId = $likeableType::inRandomOrder()->first()->id;

        // Retrieve existing user IDs and post IDs
        $userIds = User::pluck('id');

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'likeable_id' => $likeableId,
            'likeable_type' => $likeableType,
            'liked_at' => $this->faker->dateTimeThisMonth,
        ];
    }
}
