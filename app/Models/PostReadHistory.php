<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class PostReadHistory extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "post_read_histories";
    protected $primaryKey = "id";
    protected $guarded = [];
//    protected $cascadeDeletes = [];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
