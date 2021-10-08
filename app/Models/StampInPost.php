<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampInPost extends Model
{
    use HasFactory;
    protected $table = "stamp_in_posts";
    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Post::class, 'id', 'postID');
    }
    public function stamp() {
        return $this->belongsTo(Stamp::class, "stampID");
    }
}
