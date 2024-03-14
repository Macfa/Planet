<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class StampInComment extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "stamp_in_comments";
    protected $guarded = [];
//    protected $cascadeDeletes = [];

    public function comment() {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
