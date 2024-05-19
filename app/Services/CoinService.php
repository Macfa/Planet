<?php

namespace App\Services;

class CoinService {

  public function writePost(Post $post) {
    // $today = Carbon::now();  // change timestamp column has default value.
    $coin_setup = CoinSetup::findOrFail(1);
    $limit = $coin_setup->post_limit;

    // if(!auth()->check()) {
    //     return abort(401);
    // }  // common method has these work

    $user = auth()->user();
    $totalCoin = $user->hasCoins("post")->whereDate('coins.created_at', $today)->sum('coin');

    if($totalCoin > $limit) {
        // 코인 추가 획득 불가
    } else {
        $post->coins()->create([
            'type'=> '글작성',
            'coin'=> $coin_setup->post,
            'user_id'=> auth()->id()
        ]);
        // 코인 추가 획득
    }
}

public function writeComment(Comment $comment) {
    $today = Carbon::now();
    $coin_setup = CoinSetup::findOrFail(1);
    $limit = $coin_setup->comment_limit;

    if(!auth()->check()) {
        return abort(401);
    }
    $user = auth()->user();
    $totalCoin = $user->hasCoins("comment")->whereDate('coins.created_at', $today)->sum('coin');

    if($totalCoin > $limit) {
        // 코인 추가 획득 불가
    } else {
        $comment->coins()->create([
            'type'=> '댓글작성',
            'coin'=> $coin_setup->comment,
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
}