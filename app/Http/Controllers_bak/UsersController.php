<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function index(User $user) {
        $el = 'post';
        $posts = Post::with('channel')
        ->with('user')
        ->with('likes')
        ->withCount('comments')
        ->where('memberID', '=', $user->id)
        ->get();

        //
//        Point::where('memberID')
//        $pointResult = Point::where('memberID', '=', $user->id)
        $userInfo = User::with('points.pointType')->find($user->id);

        $point = array();
        $point['totalPoint'] = $userInfo->points->sum(function ($point) {
            return $point->pointType->point;
        });
        $point['postPoint'] = $userInfo->points->where('pointable_type', 'App\Models\Post')->sum(function ($point) {
            return $point->pointType->point;
        });
        $point['commentPoint'] = $userInfo->points->where('pointable_type', 'App\Models\Comment')->sum(function ($point) {
            return $point->pointType->point;
        });
        $point['postCount'] = $userInfo->points->where('pointable_type', 'App\Models\Post')->count();
        $point['commentCount'] = $userInfo->points->where('pointable_type', 'App\Models\Comment')->count();

        $point = (object)$point;
//        dd($point);

        return view('mypage.index', compact('posts', 'point', 'el'));
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
