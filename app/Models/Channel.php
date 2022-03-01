<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;

class Channel extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "channels";
    protected $primaryKey = "id";
    protected $guarded = [];
    protected array $cascadeDeletes = ['posts', 'channelJoins', 'channelAdmins', 'channelVisitHistories', 'reports'];

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
//    protected static function booted()
//    {
//        static::deleted(function ($channel) {
//        });
//    }
}
