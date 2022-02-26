<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Favorite extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;
    protected $table = "favorites";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected $cascadeDeletes = [];

    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    // public function comments() {
    //     return $this->hasMany(Comment::class, 'post_id');
    // }
    public function user() {
        return $this->belongsTo(User::class, 'memberID', 'id');
    }
}
