<?php

namespace Database\Seeders;

use App\Models\PostTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PostTag::factory(50)->create();
    }
}
