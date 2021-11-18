<?php

namespace App\Http\Controllers;

use App\Models\ChannelVisitHistory;
use App\Models\Coin;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class UserController extends Controller
{

    private Agent $agent;

    public function __construct()
    {
        $this->agent = new Agent();
        if($this->agent->isMobile()) {
            redirect('http://m.localhost:8000/');
        }
    }
    public function show(User $user, $el = 'post') {
//        $el = 'post';
        if($el == "post") {
            $posts = Post::where('user_id', $user->id)
//                ->with('user')
//                ->with('likes')
//                ->withCount('comments')
                ->get();
        } elseif($el == "comment") {
            $posts = Post::join('comments', 'posts.id', '=', 'comments.post_id')
                ->where('comments.user_id', $user->id)
                ->with('user')
                ->with('likes')
                ->withCount('comments')
//                ->groupBy('posts.id')
                ->get();
        } elseif($el == "scrap") {
//            $posts = Post::join('users', 'users.id', '=', 'posts.user _id')
            $posts = Post::leftJoin('scraps', function($join) {
//                    $join->on('users.id', '=', 'scraps.user_id');
                    $join->on('posts.id', '=', 'scraps.post_id');
                })
                ->with('channel')
                ->with('likes')
                ->withCount('comments')
                ->where('scraps.user_id', $user->id)
                ->get();
            //                ('scraps', 'users.id', '=', 'scraps.userID')
        }

        $user = User::find($user->id);
        // $visit = new Visit();
        $channelVisitHistories = ChannelVisitHistory::showHistory();

        $coin = array();
        $coin['totalCoin'] = $user->hasCoins()->sum('coin');
        $coin['postCoin'] = $user->hasCoins()->where('coinable_type', 'App\Models\Post')->sum('coin');
        $coin['commentCoin'] = $user->hasCoins()->where('coinable_type', 'App\Models\Comment')->sum('coin');
        $coin['postCount'] = $user->hasCoins()->where('coinable_type', 'App\Models\Post')->count();
        $coin['commentCount'] = $user->hasCoins()->where('coinable_type', 'App\Models\Comment')->count();

        $coin = (object)$coin;
//        dd($coin);

        if($this->agent->isMobile()) {
            return view('mobile.user.mypage', compact('posts', 'channelVisitHistories', 'user', 'coin', 'el'));
        } else {
            return view('user.show', compact('posts', 'channelVisitHistories', 'user', 'coin', 'el'));
        }
    }

    public function modify(Request $request, $id) {
        $user = User::find($id);
        $name = $request->input("name");

        // set validation rules
        $rules = [
            'name' => 'required|min:2|max:50|unique:users',
        ];

        $messages = [
            'name.required' => '이름을 입력해주세요.',
            'name.max' => '이름은 최대 50 글자 이하입니다.',
            'name.min' => '이름은 최소 2 글자 이상입니다.',
            'name.unique' => '동일한 이름이 존재합니다.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $result = $user->changeUserName($name);

        if($result) {
            return redirect()->back()->with(['msg'=>'변경되었습니다', 'type'=>'success']);
        } else {
            return redirect()->back()->with(['msg'=>'코인이 부족합니다', 'type'=>'error']);
        }
    }
    public function destroy() {
        dd(Auth::user());
//        Auth::user()->delete();
    }
    public function logedIn() {
        if(Auth::check()) {
            return true;
        } else {
            return false;
        }
    }

    public function logout(Request $request) {
//        Auth::logoutOtherDevices("4", 'id');
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        Auth::logout();
        return redirect('/')->with(["msg" => "로그아웃 되었습니다.", "type" => "info"]);
    }
}
