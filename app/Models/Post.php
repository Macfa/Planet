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

    // Custom Functions
    public function getExistPostLikeAttribute() {
        $checkExistLike = $this->likes->firstWhere('userID',auth()->id());

        if($checkExistLike) {
            return $checkExistLike->vote;
        } else {
            return 0;
        }
    }
    public function getExistPostScrapAttribute() {
        if($this->scrap) {
            $checkExistScrap = $this->scrap->where('userID', auth()->id());

            if($checkExistScrap) {
                return $checkExistScrap->where('userID', auth()->id())->count();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    public function getExistPostReportAttribute() {
        if($this->report) {
            $checkExistReport = $this->report;

            if($checkExistReport) {
                return $checkExistReport->where('userID', auth()->id())->count();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
}
