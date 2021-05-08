<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Favorite;

class MainController extends Controller
{
    //
    public function index() {
        $posts = Post::withCount('comments')
            ->with('channel')
            ->with('user')
            ->where('posts.hide', '=', '0')
            ->get()
            ->toJson();

        $favorites = Favorite::where('memberID', '=', auth()->id())
            ->with('channel')
            ->orderby('id', 'desc')
            ->get()
            ->toJson();

        $posts = json_decode($posts);
        $favorites = json_decode($favorites);
        return view('main.index', compact('posts','favorites'));
    }
}
