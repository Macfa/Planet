<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Coin extends Model
{
    use HasFactory;

    protected $table = "coins";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function coinable()
    {
        return $this->morphTo('coinable', 'coinable_type', 'coinable_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id', 'userID');
    }

    public function scopeWritePost(Builder $query, Post $post) {
//        $data = [
//            'coin' => 5,
//            'userID' => auth()->id(),
//            'action' => 'write'
//        ];

//        return $post->coins()->create($data);
//        return $query->save($data);
//        return $query->create($data);
    }
}
