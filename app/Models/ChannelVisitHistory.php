<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelVisitHistory extends Model
{
    use HasFactory;
    protected $table = "channel_visit_histories";
    protected $guarded = [];


    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channelID', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
    public static function addHistory(Channel $channel) {
        if(auth()->check()) {
            $channel->channelVisitHistories()->updateOrCreate([
                'userID' => auth()->id(),
                'channelID' => $channel->id
            ], [
                'updated_at' => now()
            ]);

            $totalCount = Visit::where('userID', auth()->id())->count();
            // 최대 5개의 방문이력만 허용
            if($totalCount >= 5) {
                Visit::where('userID', auth()->id())->orderby('updated_at', 'asc')->limit(1)->delete();
            }

            return self::showHistory();
        }
    }
    public static function showHistory() {
        if(auth()->check() ) {
            $user = User::find(auth()->id());

            return $user->channelVisitHistories()->orderby('updated_at', 'desc')->get();
        }
    }
}
