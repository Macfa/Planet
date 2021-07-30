<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user) {
        $el = 'post';
        $posts = Post::with('channel')
            ->with('user')
            ->with('likes')
            ->withCount('comments')
            ->where('userID', $user->id)
            ->get();

        $favorites = Favorite::where('userID', auth()->id() )->get();
        $userInfo = User::with('coins.coinType')->find($user->id);

        $coin = array();
        $coin['totalCoin'] = $userInfo->coins->sum('coin');
        $coin['postCoin'] = $userInfo->coins->where('coinable_type', 'App\Models\Post')->sum('coin');
        $coin['commentCoin'] = $userInfo->coins->where('coinable_type', 'App\Models\Comment')->sum('coin');
        $coin['postCount'] = $userInfo->coins->where('coinable_type', 'App\Models\Post')->count();
        $coin['commentCount'] = $userInfo->coins->where('coinable_type', 'App\Models\Comment')->count();

        $coin = (object)$coin;
//        dd($coin);

        return view('user.mypage', compact('posts', 'favorites', 'coin', 'el'));
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
