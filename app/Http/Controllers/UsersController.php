<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function index($el = 'post') {
        $posts = Post::with('channel')
        ->with('user')
        ->withCount('comments')
        ->where('memberID', '=', auth()->id())
        ->get()
        ->toJson();

        $pointResult = Point::where('memberID', '=', auth()->id())
        ->get();
        // ->toJson();

        // get data from pointResult and transform into object
        $points = array();
        $points['totalPoint'] = $pointResult->sum('point');
        $points['postPoint'] = $pointResult->where('route', 'post')->sum('point');
        $points['commentPoint'] = $pointResult->where('route', 'comment')->sum('point');
        $points = (object)$points;

        $posts = json_decode($posts);

        return view('mypage.index', compact('posts', 'points', 'el'));
    }

    public function logedIn() {
        if(Auth::check()) {
            return true;
        } else {
            return false;
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with("로그아웃 되었습니다.");
    }
}
