<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class StampInPost extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "stamp_in_posts";
    protected $guarded = [];
//    protected $cascadeDeletes = [];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function stamp() {
        return $this->belongsTo(Stamp::class, "stamp_id");
    }
}
