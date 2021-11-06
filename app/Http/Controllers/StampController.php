<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Post;
use App\Models\Stamp;
use App\Models\StampGroup;
use Illuminate\Http\Request;

class StampController extends Controller
{
    public function recentStamp() { // 최근 사용한 스탬프

    }

    public function getDataFromCategory(Request $request) {
        // 카테고리에 해당되는 데이터를 가져온다
        $categoryID = $request->input("categoryID");

        return StampGroup::getDataFromCategory($categoryID);
    }
    public function purchase(Request $request) {
        $stampID = $request->input("stamp_id");
        $postID = $request->input("postID");
        $stamp = Stamp::find($stampID);
        $post = Post::find($postID);
        $coin = new Coin();
//        dd($coin->purchaseStamp($stamp,$post));
        return $coin->purchaseStamp($stamp,$post);
    }
}
