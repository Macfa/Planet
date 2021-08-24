<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = "visits";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Post::class, 'id', 'postID');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'userID');
    }
}
