<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostReadHistory extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "post_read_histories";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
