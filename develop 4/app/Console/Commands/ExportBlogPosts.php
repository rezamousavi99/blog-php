<?php

namespace App\Console\Commands;

use App\Exports\PostsExport;
use App\Helpers\PostHelper;
use App\Models\Post;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportBlogPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $signature = 'export:blog-posts {--all : Export all blog posts from any time}';
    /**
     * Execute the console command.
     */

    public function handle()
    {
        // Check if the --all option is passed
        if ($this->option('all')) {
            // Retrieve all posts
            $posts = Post::with(['tags', 'user'])->get();
            $filename = 'exports/all_blog_posts_' . now()->format('Y-m-d');

            $this->info('Exporting all blog posts...');
        } else {
            // Retrieve posts created in the last week
            $posts = Post::with(['tags', 'user'])
                ->whereBetween('created_at', [now()->subWeek(), now()])
                ->get();
            $filename = 'exports/blog_posts_' . now()->format('Y-m-d');

            $this->info('Exporting weekly blog posts...');
        }

        // Map and format posts for export
        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'excerpt' => $post->excerpt,
                'slug' => $post->slug,
                'content' => $post->content,
                'user_name' => $post->user->user_name ?? 'Unknown',
                'created_at' => $post->created_at->toDateTimeString(),
                'updated_at' => $post->updated_at ? $post->updated_at->toDateTimeString() : null,
                'tags' => implode(', ', $post->tags->pluck('caption')->toArray()),
                'like_count' => $post->likes->count(),
            ];
        });

        // Store Excel export in storage/app/private/exports
        Excel::store(new PostsExport($formattedPosts), $filename . '.xlsx', 'local');

        $this->info('Blog posts exported successfully!');
        return 0;
    }
}
