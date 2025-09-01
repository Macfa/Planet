<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class ChannelVisitHistory extends Model
{
    // use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "channel_visit_histories";
    protected $guarded = [];
//    protected $cascadeDeletes = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public static function addHistory(Channel $channel) {
        if(auth()->check()) {

//            $checkExist = $channel->channelVisitHistories()->where('user_id', auth()->id());
            $totalCount = ChannelVisitHistory::where('user_id', auth()->id())->count();
            // 최대 5개의 방문이력만 허용
            if($totalCount > 5) {
                ChannelVisitHistory::where('user_id', auth()->id())->oldest()->limit(1)->delete();
            } else {
                $channel->channelVisitHistories()->updateOrCreate([
                    'user_id' => auth()->id(),
                    'channel_id' => $channel->id
                ], [
                    'updated_at' => now()
                ]);
            }

            return self::showHistory();
        } else {
            return [];
        }
    }
    public static function showHistory() {
        if(auth()->check() ) {
            return auth()->user()->channelVisitHistories()->orderby('created_at', 'desc')->get();
        } else {
            return [];
        }
    }
}
