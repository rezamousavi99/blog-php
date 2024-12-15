<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'caption',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }

    public static function processTags(array $tags, Post $post)
    {
        // Fetch existing tags from the database (if they exist)
        $existingTags = self::whereIn('caption', $tags)->pluck('caption', 'id')->toArray();

        // Identify the tags that don't exist yet (new tags)
        $existingCaptions = array_values($existingTags);
        $newTags = array_diff($tags, $existingCaptions);

        // Insert new tags (only those that don't exist)
        if (empty($newTags) == false) {
            $newTagData = array_map(fn($caption) => ['caption' => $caption], $newTags);
            self::insert($newTagData);
        }

        // Fetch IDs of all the tags (existing + newly inserted)
        $allTagIds = self::whereIn('caption', $tags)->pluck('id')->toArray();

        // Attach all tags to the post (existing + new)
        $post->tags()->attach($allTagIds);
    }


}
