<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampInComment extends Model
{
    use HasFactory;
    protected $table = "stamp_in_comments";
    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
