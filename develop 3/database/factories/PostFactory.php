<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->words(3, true);
        return [
            'title' => $title,
            'excerpt' => $this->faker->words(3, true),
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(1, true),
            'user_id' => User::factory(),
            'created_at' => Carbon::now('Asia/Tehran'),
            'updated_at' => null, // Set updated_at to null
        ];
    }
}
