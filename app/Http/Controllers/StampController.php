<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Stamp;
use App\Models\StampCategory;
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
        $stampID = $request->input("stampID");
        $type = $request->input("type");
        $id = $request->input("id");

        // change it to policy
        if(!auth()->check()) return response('', 401);

        $stamp = Stamp::find($stampID);
        if($type === "post") {
            $target = Post::find($id);
        } else if($type === "comment") {
            $target = Comment::find($id);
        }

        $coin = new Coin();
        $result = $coin->purchaseStamp($stamp,$target);
//        dd($result);
        return ($result) ?? response('', 400);
    }
    public function get($id) {
        $stamp = Stamp::find($id)->toArray();
        $hasCoin = auth()->user()->hasCoins()->sum('coin');
//        dd($hasCoin, $stamp->coin);
        $saveCoin = $hasCoin - $stamp['coin'];
//        $save = ($price - $stamp->coin < 0 ) ?? 'cannot;
        $coinData = [
            'hasCoin'=> $hasCoin,
            'afterPurchaseCoin' => $saveCoin
        ];

        $result = array_merge($stamp, $coinData);
        return $result;
    }
    public function show(Request $request) {
        // get input data's
        $inputs = array(
            $request->input("id"),
            $request->input("type")
        );

        // initialize Models
        $stampCategoryModel = new StampCategory();
        $stampModel = new Stamp();

        // get data
        $allCategories = $stampCategoryModel->getAllCategories();
        $allStamps = $stampModel->getAllStamps();
//        dd($allCategories, $allStamps);
        return view('layouts.stamp', compact('allCategories', 'allStamps', 'inputs'));
    }
//    public function getStampCategory($id) {
//        if($id === 0) {
            // get all data

//        } else {
//
//        }
//    }
//    public function getStamp($id) {
        // Get Parameters
//        $id = $request->input("id");
//        $type = $request->input("type");

//        $categories = "";
//        $stamps = "";
//    }
}
