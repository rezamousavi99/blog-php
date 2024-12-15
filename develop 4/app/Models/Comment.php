<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
      'comment_text',
      'user_id',
      'post_id',
    ];

    public function likes(){
        return $this->morphMany(Like::class, 'likeable');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
