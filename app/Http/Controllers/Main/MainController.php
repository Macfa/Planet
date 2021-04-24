<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Post;

class MainController extends Controller
{
    //
    public function index() {
        $posts = Post::join('channels', 'channels.id', '=', 'posts.channelID')
            ->where('posts.hide', '=', '0')
            ->get()
            ->toJson();
        $posts = json_decode($posts);
        return view('main.index', compact('posts'));
    }
}
