<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function commentPost(Request $request, Post $post){
        $incommingFields = $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

//        dd($post->id);

        $incommingFields['user_id'] = $request->user()->id;
        $incommingFields['post_id'] = $post->id;

        $comment = Comment::create([
            'comment_text' => $incommingFields['comment_text'],
            'user_id' => $request->user()->id,
            'post_id' => $post->id
        ]);

        return response()->json([
            'message' => 'Comment created successfully!',
            'comment' => $comment->id,
        ], 201);

    }
}
