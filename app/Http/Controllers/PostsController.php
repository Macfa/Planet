<?php

namespace App\Http\Controllers;

use App\Models\PointType;
use Illuminate\Http\Request;
// use App\Http\Controllers\ChannelsController;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Point;
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

        $comments = Comment::where('hide', '=', 0)
            ->where('postID', '=', $id)
            ->with('user')
            ->orderBy('group', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('depth', 'asc')
            ->get();

        return view('post.show', compact('post', 'comments'));
    }

    public function create() {
        $channels = Channel::where('hide', '=', '0')
            ->get();

        return view('post.create', compact('channels'));
    }

    public function store(Request $req) {
        // ddd($req);
        $id = Post::create([
            'channelID' => $req->input('channelID'),
            'title' => $req->input('title'),
            'content' => $req->input('content'),
            'memberID' => auth()->id(),
            'hide' => 0
        ])->id;
        // 포인트 최대값 확인을 위한 조회

        $pointType = PointType::where('type', '=', '글쓰기')->get()->first();

        // 포인트 추가
        $post = Post::find($id);
        $post->points()->create([
            'memberID' => auth()->id(),
            'pointTypeID' => $pointType->id
        ]);

        $redirect = $req->input('channelID');
        return redirect()->route('channelShow', ['id' => $redirect]);
    }

    public function destroy(Request $req) {
        $id = $req->id;

        $post = Post::find($id);
        $post->delete();
//        return redirect()->route('mainHomePage')->with('message', '삭제되었습니다.');
    }

    public function voteLikeInPost(Request $req)
    {
        // 이력 확인
        $id = $req->input('id');
        $vote = $req->input('vote');

        // 수정 및 생성
        $post = Post::find($id);
        $checkExistValue = $post->likes()
            ->where('like', $vote)
            ->first();

        if ($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
        } else {
            $result = $post->likes()
                ->updateOrCreate([
                    'memberID' => auth()->id()
                ], [
                    'like' => $vote,
                    'memberID' => auth()->id()
                ])->exists;
        }

        // 결과
        if ($result) {
            $totalVote = $post->likes->sum('like');
            return response()->json(['like' => $totalVote]);
        }
    }
}
