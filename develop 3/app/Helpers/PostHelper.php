<?php
// File: app/Helpers/PostHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class PostHelper #todo.ma: do this in post model
{
    public static function getPostWithTagsAndUser($postId)
    {
        // Retrieve post details, associated tags, and username
        $post = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.user_name')
            ->where('posts.id', $postId)
            ->first();

        if (!$post) {
            // Handle the case where the post doesn't exist
            return null;
        }

        // Retrieve associated tags for the post
        $tags = DB::table('tags')
            ->join('post_tags', 'tags.id', '=', 'post_tags.tag_id')
            ->where('post_tags.post_id', $postId)
            ->pluck('tags.caption');

        // Organize the data into a nested structure
        $formattedPost = [
            'id' => $post->id,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'slug' => $post->slug,
            'content' => $post->content,
            'user_name' => $post->user_name,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'tags' => $tags->toArray(),
        ];

        return $formattedPost;
    }



    public static function storeTagsProcess($tags, $postId){ #todo.ma: unreadable method and this method should not be here

        // Maintain a list of processed tag captions
        $processedTags = [];

        if (isset($tags)) { #todo.ma: unnecessary if
            foreach ($tags as $tagCaption) {
                // Check if the tag caption has already been processed
                if (!in_array($tagCaption, $processedTags)) {
                    $tagId = DB::table('tags')->where('caption', $tagCaption)->value('id');
                    if (!$tagId) {
                        // Insert the tag if it doesn't exist
                        $tagId = DB::table('tags')->insertGetId(['caption' => $tagCaption]);
                    }
                    // Add the processed tag caption to the list
                    $processedTags[] = $tagCaption;

                    // Insert into post_tags
                    DB::table('post_tags')->insert([
                        'post_id' => $postId,
                        'tag_id' => $tagId,
                    ]);
                }
            }
        }
    }
}
