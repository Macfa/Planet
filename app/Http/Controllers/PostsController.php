<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\ChannelsController;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Comment;

class PostsController extends Controller
{
    public function show($id) {
        $posts = Post::with('channel')
            ->withCount('comments')
            ->where('posts.hide', '=', 0)
            ->where('posts.id', '=', $id)
            ->get()
            ->first()
            ->toJson();
        $post = json_decode($posts);

        $comments = Comment::where('hide', '=', 0)
            ->where('postID', '=', $id)
            ->orderBy('group', 'asc')
            ->orderBy('parent', 'asc')
            ->orderBy('order', 'asc')
            ->orderBy('depth', 'asc')
            ->get()
            ->toJson();
        $comments = json_decode($comments);
        return view('post.show', compact('post', 'comments'));
    }

    public function create() {
        $channels = Channel::where('hide', '=', '0')
            ->get()
            ->toJson();
        $channels = json_decode($channels);
        return view('post.create', compact('channels'));
    }

    public function store(Request $req) {
        Post::create([
            'channelID' => $req->input('channelID'),
            'title' => $req->input('title'),
            'content' => $req->input('content'),
            'memberID' => 1,
            'like' => 0,
            'hate' => 0,
            'penalty' => 0,
            'hide' => 0
        ]);

        $redirect = $req->input('channelID');
        return redirect()->route('channelShow', ['id' => $redirect]);
    }
}
