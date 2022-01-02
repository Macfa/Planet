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
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
    public function coinType() {
        return $this->belongsTo(CoinType::class, 'coinTypeID', 'id');
    }

    // Custom Functions
//    public function purchaseStamp() {
//        $user = User::where('id', auth()->id())->first();
//        $totalCoin = $user->coins()->sum('coin');
//        if($totalCoin >= 5) {
//            // purchase
//            $user->coins()->create([
//                'coin'=>-5,
//                'coinable_type'=>'test',
//                'coinable_id'=>1,
//                'user_id'=>1,
//                'type'=>'test'
//            ]);
//            return true;
//        } else {
//            // can't purchase
//            return false;
//        }
//    }

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
                'user_id'=> auth()->id()
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
                'user_id'=> auth()->id()
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
                    'user_id'=>auth()->id()
                ]);
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
    public function purchaseStamp(Stamp $stamp, Model $target) {
        $user = User::find(auth()->id());
        $price = $stamp->coin;
        $totalCoin = $user->hasCoins()->sum('coin');

        if($totalCoin >= $price) {
            $stamp->coins()->create([
                'type'=>'스탬프구매',
                'coin'=>-$price,
                'user_id'=>auth()->id()
            ]);
            $className = get_class($target);
            if($className === "App\Models\Post") {
                $conditionalTarget = $target->stampInPosts();
//                $conditionalTarget = $target->stamps();
            } else if($className === "App\Models\Comment") {
                $conditionalTarget = $target->stampInComments();
            } else {
                $conditionalTarget = '';
            }
            $checkExist = $conditionalTarget->where("stamp_id", $stamp->id)->first();

            $currentCoin = $totalCoin - $price;

            if($checkExist) {
                $conditionalTarget->create([
                    'post_id' => $target->id,
                    'stamp_id' => $stamp->id,
//                        'count' => 1,
                    'user_id' => auth()->id()
                ]);
//                $toBeCount = $checkExist->count+1;
//                $conditionalTarget->update([
//                    "count" => $toBeCount
//                ]);
//                $method = "update";
                $method = "create";
            } else {
//                $toBeCount = 1;
                if($className === "App\Models\Post") {
                    $conditionalTarget->create([
                        'post_id' => $target->id,
                        'stamp_id' => $stamp->id,
//                        'count' => 1,
                        'user_id' => auth()->id()
                    ]);
                    $target = "post";
                } else if($className === "App\Models\Comment") {
                    $conditionalTarget->create([
                        'comment_id' => $target->id,
                        'stamp_id' => $stamp->id,
//                        'count' => 1,
                        'user_id' => auth()->id()
                    ]);
                    $target = "comment";
                }
                $method = "create";
            }
            return [
                "method" => $method,
                "target" => $target,
                "currentCoin" => $currentCoin,
                "image" => $stamp->image,
//                "count" => $toBeCount
            ];
        } else {
            abort(402);
        }
    }
}
