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
        return $this->hasMany(Post::class, 'channel_id', 'id');
    }
    public function channelJoins() {
        return $this->hasMany(ChannelJoin::class, 'channel_id', 'id');
    }
    public function channelAdmins() {
        return $this->hasMany(ChannelAdmin::class, 'channel_id', 'id');
    }
    public function channelVisitHistories() {
        return $this->hasMany(ChannelVisitHistory::class, 'channel_id', 'id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }
    public function scopeOwn($query)
    {
        return $query->where('user_id', auth()->id());
    }
}
