<?php

namespace App\Jobs;

use App\Events\PostPublished;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class PublishPostJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Post $post)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Publish the post if it's not published yet
        if (!$this->post->is_published) {
            $this->post->update([
                'is_published' => true,
            ]);

            PostPublished::dispatch($this->post);
        }
    }
}
