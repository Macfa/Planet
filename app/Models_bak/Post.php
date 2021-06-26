<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function channel() {
        return $this->belongsTo(Channel::class, 'channelID', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'postID');
    }
    public function user() {
        return $this->belongsTo(User::class, 'memberID', 'id');
    }
    public function likes() {
        return $this->morphMany('App\Models\Like', 'likeable');
    }
    public function points() {
        return $this->morphMany('App\Models\Point', 'pointable');
    }
}
