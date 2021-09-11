<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

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
        return $this->morphMany(Coin::class, 'coinable');
    }
    public function experiences() {
        return $this->morphMany(Experience::class, 'experienced');
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
    public function scopePagination($query, $page=0) {
        $count = 5;
        $skip = $page * $count;
//        dd([$page, $skip]);
        return $query->skip($skip)->take($count);
    }
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
//    public function EarnExpFromWritePost() {
//        $today = Carbon::now();
//        $limit = 20;
//        $totalExp = $this->experiences()->whereDate('experiences.created_at', $today)->sum('exp');
//
//        if($totalExp > $limit) {
//            // 코인 추가 획득 불가
//            $result = [
//                "code"=> "ok",
//                "msg" => "경험치일일최대"
//            ];
//
//            return $result;
//        } else {
//            try {
//                $result_craeted = $this->experiences()->create([
//                    'msg'=> '글작성',
//                    'exp'=> 5,
//                    'userID'=> auth()->id()
//                ]);
//                $result = [
//                    "code"=> "ok",
//                    "msg" => ""
//                ];
//
//                return $result;
//            } catch (Exception $e) {
//                $result = [
//                    "code"=> "err",
//                    "msg" => $e->getMessage()
//                ];
//                return $result;
//            }
//        }
//    }
}
