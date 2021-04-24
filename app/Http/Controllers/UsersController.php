<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Channel;

class UsersController extends Controller
{
    public function index() {
        $posts = Post::join('channels', 'channels.id', '=', 'posts.channelID')
        ->where('memberID', '=', 1)
        ->get()        
        ->toJson();

        $posts = json_decode($posts);
        return view('mypage.index', compact('posts'));
    }
}
