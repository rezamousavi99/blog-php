<?php

namespace App\Http\Controllers;

use App\Helpers\PostHelper;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;

class PostController extends Controller
{
    public function searchPostApi(Request $request, $term)
    {
        // Search for posts based on title, content, user_name
        $posts = DB::table('posts')
            ->select('posts.*', 'users.user_name')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.title', 'like', "%$term%")
            ->orWhere('posts.content', 'like', "%$term%")
            ->orWhere('users.user_name', 'like', "%$term%")
            ->get();

        // Retrieve detailed post information using the helper function
        $formattedResults = [];
        foreach ($posts as $post) {
            $postDetails = PostHelper::getPostWithTagsAndUser($post->id);
            if ($postDetails) {
                $formattedResults[] = $postDetails;
            }
        }

        return response()->json(['results' => $formattedResults]);
    }

    public function likePostApi(Post $post) #todo.ma: like controller
    {
        // Get the authenticated user
        $user = auth()->user();

        // Check if the user has already liked this post
        $existLike = DB::table('likes') #todo.ma: this code should be in Like model
            ->where('user_id', $user->id)
            ->where('post_id', $post->id);

        if ($existLike->first()) {
            // User has already liked the post; let's remove the like
            $existLike->delete();

            return response()->json(['message' => 'Post unliked successfully']);
        } else {
            DB::table('likes')->insert([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'liked_at' => now()
            ]);

            return response()->json(['message' => 'Post liked successfully']);
        }

    }


    public function showSinglePostApi(Post $post)
    {
//        $post = DB::table('posts')->where('id', $post->id)->get();

        //Using Helper function to get post with tags and author
        $formattedPost = PostHelper::getPostWithTagsAndUser($post->id);

        if (!$formattedPost) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Customize the response format as needed
        return response()->json(['post' => $formattedPost]);

    }

    public function updatePostApi(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'tags' => 'array' //Array of tag IDs
        ]);


        $slug = Str::slug($validatedData['title']);


        DB::table('posts')
            ->where('id', $post->id)
            ->update([
                'title' => $validatedData['title'],
                'excerpt' => $validatedData['excerpt'],
                'content' => $validatedData['content'],
                'slug' => $slug,
                'updated_at' => DB::raw('CURRENT_TIMESTAMP'),
            ]);

        // Remove existing tags for this post
        DB::table('post_tags')->where('post_id', $post->id)->delete();

        // Insert new tags based on captions
        PostHelper::storeTagsProcess($validatedData['tags'], $post->id);


        return response()->json(['message' => 'Post updated successfully']);
    }

    public function deletePostApi(Post $post)
    {
        DB::table('posts')->where('id', $post->id)->delete();

//        DB::table('posts')->where('id', $post)->delete();
//        $postId->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function showAllPostApi() #todo.ma: number of likes?
    {
        // Initialize an empty array for the formatted posts
        $formattedPosts = [];

        // Retrieve all posts
        $allPosts = DB::table('posts')->get(); #todo.ma: why get all posts here

        foreach ($allPosts as $post) {
            // Call the helper function for each post
            $formattedPost = PostHelper::getPostWithTagsAndUser($post->id); #todo.ma: N+1 problem
            if ($formattedPost) {
                $formattedPosts[] = $formattedPost;
            }

        }

        // Return a JSON response with the organized posts
        return response()->json(['message' => 'All posts retrieved successfully', 'posts' => $formattedPosts]);
    }


    public function storeNewPostApi(Request $request) #todo.ma: form request?
    {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255|unique:posts',
            'excerpt' => 'required|string', #todo.ma: max?
            'content' => 'required|string', #todo.ma: max?
            'tags' => 'array' //Array of tag IDs #todo.ma: max? unique? each tags max?
        ]);

        // Automatically generate the slug
        $slug = Str::slug($validatedData['title']);

        //Query Builder
        $postId = DB::table('posts')->insertGetId([
            'title' => $validatedData['title'],
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'slug' => $slug,
            'user_id' => $request->user()->id,
            'created_at' => DB::raw('CURRENT_TIMESTAMP'),
            //\Carbon\Carbon::now()
//            'created_at' => \Carbon\Carbon::now(),
//            'updated_at' => \Carbon\Carbon::now(),
        ]);


        PostHelper::storeTagsProcess($validatedData['tags'], $postId);

        return response()->json(['message' => 'Post created successfully', 'post-id' => $postId]);
    }

    public function test(User $user){

        dd(auth()->user()->is_admin);

    }



}
