<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "favorites";
    protected $primaryKey = "id";
    protected $guarded = [];

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
