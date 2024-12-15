<?php

namespace App\Http\Controllers;

use App\Helpers\PostHelper;
use App\Http\Requests\StoreOrUpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostSummaryResource;
use App\Jobs\PublishPostJob;
use App\Mail\PostMail;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\VarDumper\VarDumper;

class PostController extends Controller
{

    public function schedulePost(Request $request, Post $post)
    {
        $user = auth()->user();

        // Ensure the post belongs to the authenticated user
//        if ($post->user_id !== $user->id) {
//            return response()->json(['message' => 'Unauthorized'], 403);
//        }

        // Validate the publish_at date
        $validatedData = $request->validate([
            'publish_at' => 'required|date_format:Y-m-d H:i:s|after:now',
        ]);

        $publishAt = Carbon::parse($validatedData['publish_at'])->toDateString(); // Only focus on the date, not time

        // Limit to 5 scheduled posts for the same day
        $key = 'schedule-limit:' . $user->id; // Unique key for user

        // Check if the user has already scheduled 5 posts today
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['message' => 'You can only schedule 5 posts to be published every day'], 429);
        }

        // Increment the rate limit counter
        RateLimiter::hit($key, 86400); // Rate limit resets after 24 hours

        // Schedule the post by dispatching a job
        PublishPostJob::dispatch($post)->delay(Carbon::parse($validatedData['publish_at']));

        return response()->json(['message' => 'Post scheduled successfully for publication', 'post' => $post], 200);
    }
    public function searchPost(Request $request, $term)
    {
        // Use the same pagination parameter as showAllPost
        $perPage = $request->input('per_page', 5);

        // Fetch paginated posts that match the search term using the existing model method
        $paginatedPosts = Post::getAllPostsWithTagsAndLikeCounts($perPage, $term);

        // Return the results using the same PostCollection
        return new PostCollection($paginatedPosts);
    }
    public function showAllPost(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $term = $request->input('search', null);

        // Fetch paginated posts
        $paginatedPosts = Post::getAllPostsWithTagsAndLikeCounts($perPage, $term);

        // Return raw paginated data for debugging
        return new PostCollection($paginatedPosts);
    }

    public function showSinglePost(Request $request, Post $post)
    {
        $perPageComments = $request->input('per_page_comments', 5);

        // Load the post with related data (tags, user, likes)
        $post->load(['tags', 'user', 'likes']);

        // Use PostDetailResource to format the response
        return new PostDetailResource($post);
    }


    public function updatePost(StoreOrUpdatePostRequest $request, Post $post)
    {
        $validatedData = $request->validated();


        $slug = Str::slug($validatedData['title']);

        // Retrieve the post
        $post = Post::find($post->id);

        // Update its attributes
        $post->title = $validatedData['title'];
        $post->excerpt = $validatedData['excerpt'];
        $post->content = $validatedData['content'];
        $post->slug = $slug;
        $post->updated_at = now();

        $post->save();

        // Detach existing tags
        $post->tags()->detach();

        // Insert new tags based on captions
        if (isset($validatedData['tags']) && is_array($validatedData['tags'])) {
            Tag::processTags($validatedData['tags'], $post);
        }

        $this->deleteJobIfExisted($post->id);


        return response()->json(['message' => 'Post updated successfully']);
    }

    public function deletePost(Post $post)
    {
        $post = Post::find($post->id);
        if ($post) {
            // First, delete the post
            $post->delete();

            $this->deleteJobIfExisted($post->id);

            return response()->json(['message' => 'Post deleted successfully']);
        }

        return response()->json(['message' => 'Post not found'], 404);
    }


    public function storeNewPost(StoreOrUpdatePostRequest $request)
    {
        $validatedData = $request->validated();

        // Automatically generate the slug
        $slug = Str::slug($validatedData['title']);

        $post = Post::create([
            'title' => $validatedData['title'],
            'excerpt' => $validatedData['excerpt'],
            'content' => $validatedData['content'],
            'slug' => $slug,
            'user_id' => $request->user()->id,
            'created_at' => now(),
            'updated_at' => null
        ]);

        if (isset($validatedData['tags']) && is_array($validatedData['tags'])) {
            Tag::processTags($validatedData['tags'], $post);
        }

        return response()->json(['message' => 'Post created successfully', 'post-id' => $post->id]);
    }

    private function deleteJobIfExisted($postId){
        // if this post was scheduled before delete related job if not nothing happens
        DB::table('jobs')
            ->where('payload', 'LIKE', '%"id\\\";i:' . $postId . ';%')
            ->delete();
    }

}
