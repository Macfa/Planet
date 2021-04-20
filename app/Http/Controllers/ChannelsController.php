<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Post;

class ChannelsController extends Controller
{
    public function index() {
        $posts = Post::where('hide', '=', '0')
            ->get()
            ->toJson();
        $posts = json_decode($posts);
        return view('channel.index', compact('posts'));
    }

    public function create() {
        return view('channel.create');
    }

    public function store(Request $req) {
        Channel::create([
            'name' => $req->input('name'),
            'description' => $req->input('description'),
            'owner' => 1,
            'hide' => 0
        ]);        

        // return back()->withInput();
        return redirect()->route('channelMain');
    }

    public function show($id) {
        $posts = Post::where('hide', '=', 0)
            ->where("channelID", '=', $id)
            ->get()
            ->toJson();

        $posts = json_decode($posts);
        return view('channel.index', compact('posts'));
    }
}

