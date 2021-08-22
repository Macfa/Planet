<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Post::class);
    }
    public function user() {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
    public function likes() {
        return $this->morphMany(Like::class, 'likeable');
    }
    public function coins() {
        return $this->morphMany('App\Models\Coin', 'coinable');
    }
    public function alarms() {
        return $this->morphMany('App\Models\AlarmNotification', 'alarm_notifiable');
    }
//    public function reports() {
//        return $this->morphMany(Report::class, 'reportable');
//    }
    public function scrap()
    {
        return $this->hasOne('App\Models\Scrap', 'postID', 'id');
    }
}
