<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\CoinType;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = Channel::get();

        return view('post.create', compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Post::create([
            'channelID' => $request->input('channelID'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'userID' => auth()->id()
        ])->id;

        // 포인트 최대값 확인을 위한 조회
        $coinType = CoinType::where('type','글쓰기')->get()->first();

//        // 포인트 추가
//        $post = Post::find($id);
//        $post->coins()->create([
//            'userID' => auth()->id(),
//            'coinTypeID' => $coinType->id
//        ]);

        $redirect = $request->input('channelID');
        return redirect()->route('channel.show', $redirect);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('channel')
            ->withCount('comments')
            ->with('likes')
            ->with('user')
            ->where('posts.id', '=', $id)
            ->get()
            ->first();

        $comments = Comment::where('postID', '=', $id)
            ->with('user')
            ->orderBy('group', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('depth', 'asc')
            ->get();

        return view('post.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $channels = Channel::get();

        return view('post.create', compact('channels', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Post::where('id', $id)
            ->update([
                'title'=>$request->title,
                'channelID'=>$request->channelID,
                'content'=>$request->content
            ]);

        return redirect()->route('post.show', $id, 302);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::where('id', $id)
            ->delete();

        return redirect()->route('home', '',302);
    }

    public function voteLikeInPost(Request $req)
    {
        // 이력 확인
        $id = $req->input('id');
        $vote = $req->input('vote');

        // 수정 및 생성
        $post = Post::find($id);
        $checkExistValue = $post->likes()
            ->where('vote', $vote)
            ->first();

        if ($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
        } else {
            $result = $post->likes()
                ->updateOrCreate([
                    'userID' => auth()->id()
                ], [
                    'vote' => $vote,
                    'userID' => auth()->id()
                ])->exists;
        }

        // 결과
        if ($result) {
            $totalVote = $post->likes->sum('vote');
            return response()->json(['vote' => $totalVote]);
        }
    }
}
