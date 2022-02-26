<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StampInComment extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "stamp_in_comments";
    protected $guarded = [];

    public function comment() {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
