<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Favorite;

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
        $lastID = Channel::create([
            'name' => $req->input('name'),
            'description' => $req->input('description'),
            'owner' => auth()->id(),
            'hide' => 0
        ])->id;

        // return back()->withInput();
        return redirect()->route('channelShow', ['id' => $lastID]);
    }

    public function show($id) {
        // get all of posts with channels
        $posts = Post::with('channel')
            ->withCount('comments')
            ->with('user')
            ->where('posts.hide', '=', 0)
            ->where("posts.channelID", '=', $id)
            ->get()
            ->toJson();

        // favorite info
        $favorites = Favorite::where('memberID', '=', auth()->id())
            ->with('channel')
            ->orderby('id', 'desc')
            ->get()
            ->toJson();

        // channel info
        $channel = Channel::where('hide', '=', 0)
            ->where('id', '=', $id)
            ->get()
            ->first()
            ->toJson();
        
        $posts = json_decode($posts);
        $channel = json_decode($channel);
        $favorites = json_decode($favorites);

        return view('channel.show', compact('posts', 'channel', 'favorites'));
    }
    public function addFavorite($id) {
        Favorite::create([
            'memberID' => auth()->id(),
            'channelID' => $id
        ]);
    }
}

