<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Stamp;
use App\Models\StampCategory;
use App\Models\StampGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

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
        if(!auth()->check()) return response()->json([
            "errorType" => "login",
            "errorText" => "로그인이 필요한 기능입니다"
        ], 400);
        $stamp = Stamp::find($stampID);
        if($type === "post") {
            $target = Post::find($id);
        } else if($type === "comment") {
            $target = Comment::find($id);
        }

        // Coin
        $user = User::find(auth()->id());
        $price = $stamp->coin;
        $totalCoin = $user->hasCoins()->sum('coin');

        if($totalCoin >= $price) {
            $stamp->coins()->create([
                'type'=>'스탬프구매',
                'coin'=>-$price,
//                'coin'=>$price,
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
//            $checkExist = $conditionalTarget->where("stamp_id", $stamp->id)->first();

            $currentCoin = $totalCoin - $price;

//            if($checkExist) {
//                $conditionalTarget->create([
//                    'post_id' => $target->id,
//                    'stamp_id' => $stamp->id,
//                        'count' => 1,
//                    'user_id' => auth()->id()
//                ]);
//                $toBeCount = $checkExist->count+1;
//                $conditionalTarget->update([
//                    "count" => $toBeCount
//                ]);
//                $method = "update";
//                $method = "create";
//            } else {
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
//            }
            return [
                "target" => $target,
                "currentCoin" => $currentCoin,
                "image" => $stamp->image,
                "count" => $conditionalTarget->where('stamp_id', $stamp->id)->count()
            ];
        } else {
            return response()->json(
                [
                    "errorType" => "coin",
                    "errorText" => "코인이 부족합니다"
            ], 400);
        }
//        dd($result);
//        return ($result) ?? response('', 400);
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

        $agent = new Agent();
        if($agent->isMobile()) {
            return view('mobile.layouts.stamp', compact('allCategories', 'allStamps', 'inputs'));
        } else {
            return view('layouts.stamp', compact('allCategories', 'allStamps', 'inputs'));
        }
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
