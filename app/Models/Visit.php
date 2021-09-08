<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = "visits";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channelID', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
    public function addHistory(Channel $channel) {
        $channel->visits()->updateOrCreate([
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

        return $this->showHistory();
    }
    public function showHistory() {
        $user = User::find(auth()->id());
        return $user->visits()->orderby('updated_at', 'desc')->get();
    }
}
