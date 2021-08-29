<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Coin extends Model
{
    use HasFactory;

    protected $table = "coins";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function coinable()
    {
        return $this->morphTo('coinable', 'coinable_type', 'coinable_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id', 'userID');
    }
    public function coinType() {
        return $this->belongsTo(CoinType::class, 'coinTypeID', 'id');
    }

    // Custom Functions
    public function purchaseStamp() {
        $user = User::where('id', auth()->id())->first();
        $totalCoin = $user->coins()->sum('coin');
        if($totalCoin >= 5) {
            // purchase
            $user->coins()->create([
                'coin'=>-5,
                'coinable_type'=>'test',
                'coinable_id'=>1,
                'userID'=>1,
                'type'=>'test'
            ]);
            return true;
        } else {
            // can't purchase
            return false;
        }
    }

    public function writePost(Post $post) {
        $today = Carbon::now();
        $limit = 50;
//        $totalCoin = $post->coins()->where('created_at', $today)->sum('coin');
//        $totalCoin = $post->join('coins', 'coins.coinable_type', '=', 'test')->whereDate('coins.created_at', $today)->sum('coin');
        $totalCoin = $post->coins()->whereDate('coins.created_at', $today)->sum('coin');

        if($totalCoin > $limit) {
            // 코인 추가 획득 불가
        } else {
            $post->coins()->create([
                'type'=> '글작성',
                'coin'=> 5,
                'userID'=> auth()->id()
            ]);
            // 코인 추가 획득
        }
    }

    public function writeComment(Comment $comment) {
        $today = Carbon::now();
        $limit = 50;
        $totalCoin = $comment->coins()->whereDate('coins.created_at', $today)->sum('coin');

        if($totalCoin > $limit) {
            // 코인 추가 획득 불가
        } else {
            $comment->coins()->create([
                'type'=> '댓글작성',
                'coin'=> 1,
                'userID'=> auth()->id()
            ]);
            // 코인 추가 획득
        }
    }
    public function changeUserName(User $user) {
        $checkChanged = $user->isNameChanged;
        $limit = 100;
        $totalCoin = $user->hasCoins()->sum('coin');
//        dd($user);
        if($checkChanged === 'Y') {

            if($totalCoin > $limit) {
                $user->coins()->create([
                    'type'=>'아이디변경',
                    'coin'=>-100,
                    'userID'=>auth()->id()
                ]);
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
