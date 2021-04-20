<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $primaryKey = "id";
    protected $guarded = [];    

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function comment() {
        return $this->hasMany(Comment::class);
    }
}
