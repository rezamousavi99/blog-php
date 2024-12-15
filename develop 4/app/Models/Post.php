<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Post extends Model
{
    use HasFactory;

//    public $timestamps = false;


    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'slug',
        'user_id',
        'is_published',
        'created_at',
        'updated_at',
    ];


    public function likes(){
        return $this->morphMany(Like::class, 'likeable');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // Check if the current user has liked this post
    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Method to retrieve all posts with tags, user, and like counts
    public static function getAllPostsWithTagsAndLikeCounts($perPage = 5, $term = null)
    {
        $query = self::with(['tags', 'user', 'likes', 'comments'])  // Load comments
            ->where('is_published', true);

        if ($term) {
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%$term%")
                    ->orWhere('content', 'like', "%$term%");
            })->orWhereHas('user', function ($q) use ($term) {
                $q->where('user_name', 'like', "%$term%");
            });
        }

        return $query->paginate($perPage);
    }


}
