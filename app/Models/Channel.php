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
    public function channelJoin() {
        return $this->hasMany(ChannelJoin::class, 'channelID', 'id');
    }
    public function channelVisitHistories() {
        return $this->hasMany(ChannelVisitHistory::class, 'channelID', 'id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'userID');
    }
    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }
    public function scopeOwn($query)
    {
        return $query->where('userID', auth()->id());
    }
}
