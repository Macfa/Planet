<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Coin;
use App\Models\CoinType;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    public function create(Request $request)
    {
        $fromChannelID = $request->input('channelID');
        $channels = Channel::get();

        return view('post.create', compact('channels', 'fromChannelID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 이미지 소스만 추출
        $content = $request->input('content');
        $regex = "/https?:\/\/\S+image+\S+\.[gif|png|jpg|jpeg]+/";
        preg_match($regex, $content,$matchSubject);

        if($matchSubject == []) {
            // 이미지 소스를 추출하지못했다면
            $mainImageUrl = '/image/thum.jpg';
        } else {
            // 첫번째 이미지 소스를 대표이미지로 지정
            $mainImageUrl = $matchSubject[0];
        }

        $id = Post::create([
            'channelID' => $request->input('channelID'),
            'image' => $mainImageUrl,
            'title' => $request->input('title'),
            'content' => $content,
            'userID' => auth()->id()
        ])->id;


        // 포인트 추가
        $post = Post::find($id);
        $coin = new Coin();
        $coin->writePost($post);

//        $post->coins()->writePost($post);
//        $post->coins()->qwer();
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
//            ->get()
            ->first();

        $comments = Comment::where('postID', '=', $id)
            ->with('user')
            ->with('likes')
            ->orderBy('group', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('depth', 'asc')
            ->get();

        $etc = array();
        $etc['like'] = Post::find($id)->likes()->where('userID', auth()->id())->value('vote');

        $etc['scrap'] = Post::find($id)->scrap()->where('userID', auth()->id())->count();
        $etc['report'] = Post::find($id)->report()->where('userID', auth()->id())->count();
        $etc = (object) $etc;

        return view('post.show', compact('post', 'comments', 'etc'));
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

//        return redirect()->route('home', '',302);
        return true;
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
            return response()->json(['totalVote' => $totalVote, 'vote' => $vote]);
        }
    }

    public function reportPost(Request $req) {
        $postID = $req->id;
        $post = Post::find($postID);
        $post->report()->create([
            'userID' => $post->userID,
            'message' => 'test'
        ]);
    }
    public function scrapPost(Request $req) {
        $postID = $req->id;
        $post = Post::find($postID);

        $checkExistScrap = $post->scrap()->where('userID', auth()->id())->first();

        if($checkExistScrap != null) {
            $checkExistScrap->delete();
            $result = "delete";
        } else {
            $post->scrap()->create([
                'userID' => auth()->id()
            ]);
            $result = "insert";
        }
        return response()->json(['result' => $result]);
    }
}
