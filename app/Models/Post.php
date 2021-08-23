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
        return $this->belongsTo(Channel::class, 'channelID', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'postID');
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
    public function report() {
        return $this->morphOne(Report::class, 'reportable');
    }
    public function scrap() {
        return $this->hasOne(Scrap::class, 'postID', 'id');
    }
}
