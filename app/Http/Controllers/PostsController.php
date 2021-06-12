<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\ChannelsController;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Point;
use App\Models\PointInfoList;
use App\Models\Like;

class PostsController extends Controller
{
    public function show($id) {
        $post = Post::with('channel')
            ->withCount('comments')
            ->with('likes')
            ->with('user')
            ->where('posts.hide', '=', 0)
            ->where('posts.id', '=', $id)
            ->get()
            ->first();
//        $post = json_decode($post);

        $comments = Comment::where('hide', '=', 0)
            ->where('postID', '=', $id)
            ->with('user')
            ->orderBy('group', 'asc')
            ->orderBy('parent', 'asc')
            ->orderBy('order', 'asc')
            ->orderBy('depth', 'asc')
            ->get();
//            ->toJson();
//        $comments = json_decode($comments);
        // ddd($post);
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
        // ddd($req);
        Post::create([
            'channelID' => $req->input('channelID'),
            'title' => $req->input('title'),
            'content' => $req->input('content'),
            'memberID' => auth()->id(),
            'hide' => 0
        ]);

        // get point info's list
        // $pointInfoList = PointInfoList::where('action', '글쓰기')
        // ->get()
        // ->first();

        // earn point
        // Point::create([
        //     'memberID' => auth()->id(),
        //     'point' => $pointInfoList['point'],
        //     'route' => $pointInfoList['route'],
        //     'action' => $pointInfoList['action'],
        //     'msg' => $pointInfoList['msg']
        // ]);

        $redirect = $req->input('channelID');
        return redirect()->route('channelShow', ['id' => $redirect]);
    }

    public function likeVote(Request $req) {
        // 이력 확인
        $id = $req->input('id');
        $vote = $req->input('vote');

        $post = Post::find($id);
        $post->likes()
            ->updateOrCreate([
            'memberID'=>auth()->id()
        ], [
            'like' => $vote,
            'memberID'=>auth()->id()
        ]);

        return response()->json(['like' => $vote]);
    }
}
