<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostReadHistory extends Model
{
    use HasFactory;

    protected $table = "post_read_histories";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Post::class, 'postID', 'id');
    }
}
