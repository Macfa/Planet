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
    private $count = 10;

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
    public function hasPostReadHistories() {
        $userID = auth()->id();
        return $this->hasMany(PostReadHistory::class, 'postID')->where('userID', $userID);
    }
    public function postReadHistories() {
        return $this->hasMany(PostReadHistory::class, 'postID');
    }

    // Custom Functions
    public function scopePagination($query, $page=0) {
        $skip = $page * $this->count;
//        dd([$page, $skip]);
        return $query->skip($skip)->take($this->count);
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
    public static function getData() {
        return self::withCount('comments')
            ->orderby('id', 'desc')
            ->pagination()
            ->get();
    }
    public static function willRemove() {
        return self::withCount('comments')
            ->doesntHave('postReadHistories')
            ->orderby('id', 'desc')
            ->pagination()
            ->get();
    }
    public static function mainMenu($type, $channelID, $page) {
//        var_dump($type, $channelID, $page);
        if($type==='realtime') {
            $posts = self::with('channel')
                ->with('likes')
                ->with('user')
                ->withCount('comments')
                ->orderby('id', 'desc')
                ->where(function($query) use ($channelID) {
                    if($channelID) {
                        $query->where('channelID', '=', $channelID);
                    }
                })
                ->pagination($page)
                ->get();
        } else if($type==='hot') {
            $posts = self::with('channel')
                ->with('likes', function($q) {
                    $q->orderby('vote', 'desc');
                })
                ->withCount('comments')
                ->with('user')
                ->where(function($query) use ($channelID) {
                    if($channelID) {
                        $query->where('channelID', '=', $channelID);
                    }
                })
                ->pagination($page)
                ->get();
        }

        foreach($posts as $idx => $post) {
            $posts[$idx]['totalVote'] = $post->likes->sum('vote');
            $posts[$idx]['created_at_modi'] = $post->created_at->diffForHumans();
        }
        return $posts;
    }
}
