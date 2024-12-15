<?php

namespace App\Http\Controllers;

use App\Helpers\PostHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostsExport;

class ReportController extends Controller
{
    public function downloadPostsAsExcel()
    {
        if(!auth()->user()->is_admin){
            return response()->json(['error' => 'Only admins can export posts as Excel.'], 403);
        }
        // Initialize an empty collection for the formatted posts
        $formattedPosts = collect(); // Create an empty collection

        // Retrieve all posts
        $allPosts = DB::table('posts')->get();

        foreach ($allPosts as $post) {
            // Call the helper function for each post
            $formattedPost = PostHelper::getPostWithTagsAndUser($post->id);
            if ($formattedPost) {
                $formattedPosts->push($formattedPost); // Add to the collection
            }
        }

        return Excel::download(new PostsExport($formattedPosts), 'posts.xlsx');
    }

    public function usersLikedPostApi(Request $request, $postId){
        $likedUsers = DB::table('likes')
            ->select('users.*')
            ->join('users', 'likes.user_id', '=', 'users.id')
            ->where('likes.post_id', $postId)
            ->get();

        return response()->json(['liked_users' => $likedUsers]);
    }


    public function tagsPostCountApi(){
        $postsByTag = DB::table('tags')
            ->select('tags.caption as caption', DB::raw('COUNT(post_tags.post_id) as post_nums'))
            ->join('post_tags', 'tags.id', '=', 'post_tags.tag_id')
            ->groupBy('tags.caption')
            ->get();

        // Transform the result into an array
        $tagData = $postsByTag->map(function ($tag) {
            return [
                'caption' => $tag->caption,
                'post_nums' => $tag->post_nums,
            ];
        });

        // Return the data as a JSON response
        return response()->json(['data' => $tagData]);
    }

}
