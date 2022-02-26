<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Scrap extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "scraps";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id', 'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
