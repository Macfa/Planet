<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Post::class);
    }
    public function user() {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
    public function likes() {
        return $this->morphMany('App\Models\Like', 'likeable');
    }
    public function coins() {
        return $this->morphMany('App\Models\Coin', 'coinable');
    }

    // Functions...
//    public function checkExist() {
//    }
}
