<?php

namespace Database\Factories;

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
        // Retrieve existing user IDs and post IDs
        $userIds = User::pluck('id');
        $postIds = Post::pluck('id');

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'post_id' => $this->faker->randomElement($postIds),
            'liked_at' => $this->faker->dateTimeThisMonth,
        ];
    }
}
