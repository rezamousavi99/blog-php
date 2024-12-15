<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve existing users
        $users = User::all();

        // Create posts for each user
        $users->each(function ($user) {
            Post::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
