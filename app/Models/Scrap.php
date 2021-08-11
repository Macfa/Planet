<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrap extends Model
{
    use HasFactory;

    protected $table = "scraps";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id', 'postID');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'userID');
    }
}
