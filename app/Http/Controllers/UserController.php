<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user, $el = 'post') {
//        $el = 'post';
        if($el == "post") {
            $posts = Post::with('channel')
                ->with('user')
                ->with('likes')
                ->withCount('comments')
                ->where('userID', $user->id)
                ->get();
        } elseif($el == "comment") {
            $posts = Post::where('comments.userID', $user->id)
                ->join('comments', 'posts.id', '=', 'comments.postID')
                ->with('user')
                ->with('likes')
                ->withCount('comments')
                ->get();
        } elseif($el == "scrap") {
            $posts = Post::with('channel')
                ->with('user')
                ->with('likes')
                ->withCount('comments')
                ->where('userID', $user->id)
                ->get();
        }

        $favorites = Favorite::where('userID', auth()->id() )->get();
        $user = User::find($user->id);

        $coin = array();
        $coin['totalCoin'] = $user->coins->sum('coin');
        $coin['postCoin'] = $user->coins->where('coinable_type', 'App\Models\Post')->sum('coin');
        $coin['commentCoin'] = $user->coins->where('coinable_type', 'App\Models\Comment')->sum('coin');
        $coin['postCount'] = $user->coins->where('coinable_type', 'App\Models\Post')->count();
        $coin['commentCount'] = $user->coins->where('coinable_type', 'App\Models\Comment')->count();

        $coin = (object)$coin;
//        dd($coin);

        return view('user.mypage', compact('posts', 'favorites', 'user', 'coin', 'el'));
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
