<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $table = "channels";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function posts() {
        return $this->hasMany(Post::class, 'id', 'chnnelID');
    }
    public function favorite() {
        return $this->belongsTo(Favorite::class, 'id', 'id');
    }
}
