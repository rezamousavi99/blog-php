<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Mail\PostMail;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPostPublishedEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostPublished $event): void
    {


        $post = $event->post;
        $author = $post->user;
        $postUrl = route('show-single-post', ['post' => $post->id]);

        // Get all users except the author
        $users = User::where('id', '!=', $author->id)->get();

        foreach ($users as $user) {
            Mail::send('emails.post-mail', ['title' => $post->title, 'author' => $author->user_name, 'authorEmail' => $author->email, 'postUrl' => $postUrl], function ($message) use ($user, $post) {
                $message->to($user->email)
                    ->subject("New Post Published: {$post->title}");
            });

            // Store the notification in the database
            Notification::create([
                'user_id' => $user->id,
                'message' => "New post published by {$author->user_name}: {$post->title}",
                'post_id' => $post->id,
                'url' => $postUrl
            ]);
        }

    }
}
