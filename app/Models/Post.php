<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "posts";
    protected $primaryKey = "id";
    protected $guarded = [];
    private int $count = 10;

    public function channel() {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function likes() {
        return $this->morphMany(Like::class, 'likeable');
    }
    public function coins() {
        return $this->morphMany(Coin::class, 'coinable');
    }
    public function stampInPosts() {
        return $this->hasMany(StampInPost::class, 'post_id')
//            ->groupBy("stamp_id");
        ;
    }
    public function stamps() {
        return $this->hasManyThrough(
            Stamp::class,
            StampInPost::class,
            'post_id',
            'id',
            'id',
            'stamp_id'
        );
    }
    public function stampsCount() {
        return $this->stamps()
            ->select('*', DB::raw('count(*) as totalCount'))
            ->groupBy(["stamp_in_posts.post_id", "stamps.id"]);
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
        return $this->hasOne(Scrap::class, 'post_id', 'id');
    }
    public function hasPostReadHistories() {
        $user_id = auth()->id();
        return $this->hasMany(PostReadHistory::class, 'post_id')->where('user_id', $user_id);
    }
    public function postReadHistories() {
        return $this->hasMany(PostReadHistory::class, 'post_id');
    }

    // Custom Functions
    public function scopePagination($query, $page=0) {
        $skip = $page * $this->count;
//        dd([$page, $skip]);
        return $query->skip($skip)->take($this->count);
    }
    public function getExistPostLikeAttribute() {
        $checkExistLike = $this->likes->firstWhere('user_id',auth()->id());

        if($checkExistLike) {
            return $checkExistLike->like;
        } else {
            return 0;
        }
    }
    public function getExistPostScrapAttribute() {
        if($this->scrap) {
            $checkExistScrap = $this->scrap->where('user_id', auth()->id());

            if($checkExistScrap) {
                return $checkExistScrap->where('user_id', auth()->id())->count();
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
                return $checkExistReport->where('user_id', auth()->id())->count();
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    public static function getAllData() {
        return self::orderby('id', 'desc')
            ->pagination()
            ->get();
//        withCount('comments')
//            ->with('stampInPosts.stamp')
    }
    public static function willRemove() {
        return self::doesntHave('postReadHistories')
            ->orderby('id', 'desc')
            ->pagination()
            ->get();
    }
    public static function mainMenu($type="realtime", $channelID=null, $page=0) {
        if($type==='realtime') {
            $posts = self::with('channel')
                ->with('likes')
                ->with('user')
//                ->with('stamps')
                ->withCount('comments')
                ->orderby('id', 'desc')
                ->where(function($query) use ($channelID) {
                    if($channelID) {
                        $query->where('channel_id', '=', $channelID);
                    }
                })
//                ->groupBy(["posts.id", "stamps.id"])
                ->pagination($page)
                ->get();
//                ->toSql();
//            dd($posts);
        } else if($type==='hot') {
            $posts = self::with('channel')
//                ->with('likes')
                ->with('likes', function ($q) {
                    $q->orderBy('like', 'desc');
                })
                ->withCount('comments')
                ->with('user')
//                ->with('stamps', function($query) {
//                    $query->select('*', DB::raw('count(*) as totalCount'));
//                    $query->groupBy(["stamp_in_posts.post_id", "stamps.id"]);
//                })
                ->where(function ($query) use ($channelID) {
                    if ($channelID) {
                        $query->where('channel_id', '=', $channelID);
                    }
                })
//                ->orderBy('likes.like', 'desc')
                ->pagination($page)
                ->get();
        }
//        } else if($type==="scrap") {
//            $posts = self::with('channel')
//                ->with('likes')
//                ->with('user')
//                ->with('stamps')
//                ->withCount('comments')
//                ->orderby('id', 'desc')
//                ->join("scraps", "posts.id", "=", "scraps.post_id")
//                ->pagination($page)
//                ->get();
//        }
//        $posts->toSql();
        foreach($posts as $idx => $post) {
            $posts[$idx]['totalLike'] = $post->likes->sum('like');
            $posts[$idx]['created_at_modi'] = $post->created_at->diffForHumans();
//            dd($posts, $posts->count(), $post->stamps, $post->stamps);
//            foreach($post->stamps as $stamp_idx => $stamp) {
//                dd($stamp, $stamp->count());
//                $stamp['totalCount'] = $stamp->count();
//            }
        }
        return $posts;
    }
}
