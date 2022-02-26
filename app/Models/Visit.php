<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = "visits";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function addHistory(Channel $channel) {
        if(auth()->check()) {
            $channel->channelVisitHistories()->updateOrCreate([
                'user_id' => auth()->id(),
                'channel_id' => $channel->id
            ], [
                'updated_at' => now()
            ]);

            $totalCount = Visit::where('user_id', auth()->id())->count();
            // 최대 5개의 방문이력만 허용
            if($totalCount >= 5) {
                Visit::where('user_id', auth()->id())->orderby('updated_at', 'asc')->limit(1)->delete();
            }

            return $this->showHistory();
        }
    }
    public static function showHistory() {
        if(auth()->check() ) {
            $user = User::find(auth()->id());

            return $user->channelVisitHistories()->orderby('updated_at', 'desc')->get();
        }
    }
}
