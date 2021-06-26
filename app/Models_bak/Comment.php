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
        return $this->belongsTo(User::class, 'memberID', 'id');
    }
    public function likes() {
        return $this->morphMany('App\Models\Like', 'likeable');
    }
    public function points() {
        return $this->morphMany('App\Models\Point', 'pointable');
    }

    // Functions...
//    public function checkExist() {
//    }
}
