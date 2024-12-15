<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // Like a comment
    public function likeComment(Request $request, Comment $comment)
    {
        return $this->likeEntity($comment, $request->user(), true);
    }

    // Unlike a comment
    public function unlikeComment(Request $request, Comment $comment)
    {
        return $this->likeEntity($comment, $request->user(), false);
    }

    // Like a post
    public function likePost(Request $request, Post $post)
    {
        return $this->likeEntity($post, $request->user(), true);
    }

    // Unlike a post
    public function unlikePost(Request $request, Post $post)
    {
        return $this->likeEntity($post, $request->user(), false);
    }


    // like or unlike any likeable entity (post or comment)
    private function likeEntity($entity, $user, $like = true)
    {
        // Check if the like already exists
        $likeExists = $entity->likes()->where('user_id', $user->id)->exists();

        // If liking, create the like if it doesn't exist
        if ($like) {
            if ($likeExists) {
                return response()->json(['message' => 'You have already liked this item'], 409);
            }
            $entity->likes()->create(['user_id' => $user->id]);

            return response()->json(['message' => 'Liked successfully'], 201);
        }

        // If unliking, delete the like if it exists
        if (!$like && $likeExists) {
            $entity->likes()->where('user_id', $user->id)->delete();

            return response()->json(['message' => 'Unliked successfully'], 200);
        }

        return response()->json(['message' => 'No like found to unlike'], 404);
    }
}
