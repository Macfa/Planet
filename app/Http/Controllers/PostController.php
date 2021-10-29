<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\ChannelVisitHistory;
use App\Models\Coin;
use App\Models\CoinType;
use App\Models\Comment;
use App\Models\Experience;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class PostController extends Controller
{
    private Agent $agent;

    public function __construct()
    {
        $this->agent = new Agent();
        if($this->agent->isMobile()) {
            redirect('http://m.localhost:8000/');
        }
    }
    public function home() {
        $posts = Post::getAllData();
        $channelVisitHistories = ChannelVisitHistory::showHistory();
        return view('main.index', compact('posts', 'channelVisitHistories'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::getAllData();

        $channelVisitHistories = ChannelVisitHistory::showHistory();
        return view('main.index', compact('posts', 'channelVisitHistories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Post::class);

        $user = User::find(auth()->id());
//        $fromChannelID = $request->input('channelID');
        $prevUrl = url()->previous();
        $prevUrlArr = explode('/', $prevUrl);
        $fromChannelID = end($prevUrlArr);

//        $channels = Channel::own()->get();

        if($this->agent->isMobile()) {
            return view('mobile.post.create', compact('user', 'fromChannelID'));
        } else {
            return view('post.create', compact('user', 'fromChannelID'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        // set validation rules
        $rules = [
            'channelID' => 'required',
            'title' => 'required|max:200',
            'content' => 'required|min:1',
        ];

        $messages = [
            'channelID.required' => '채널을 선택해주세요.',
            'title.required' => '제목을 입력해주세요.',
            'content.required' => '내용을 입력해주세요.',
            'max' => '제목은 최대 255 글자 이하입니다.',
            'min' => '내용은 최소 1글자 이상입니다.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        // 이미지 소스만 추출
        $content = $request->input('content');
        $regex = "/https?:\/\/\S+image+\S+\.[gif|png|jpg|jpeg]+/";
        preg_match($regex, $content,$matchSubject);

        if($matchSubject == []) {
            // 이미지 소스를 추출하지못했다면
            $mainImageUrl = null;
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
//        $post->saveCoinForWritePost();
//        dd($post->coins());
        $coin = new Coin();
        $experience = new Experience();

        $coin->writePost($post);
        $experience->writePost($post);

        $redirect = $request->input('channelID');
        return redirect()->route('channel.show', $redirect)->with(["status"=>"success", "message"=>"생성되었습니다"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userID = auth()->id();
        $post = Post::with('channel')
            ->withCount('comments')
            ->with('stampInPosts')
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

        if($userID) {
            // 게시글 열람이력을 추가한다
            $post->postReadHistories()->updateOrCreate(
                ["userID" => $userID],
                ['updated_at' => now()]
            );
        }
//        return view('main.index', compact('post', 'comments'));
//        dd($this->agent->isMobile());
        if($this->agent->isMobile()) {
            return view('mobile.post.show', compact('post', 'comments'));
        } else {
            return view('post.show', compact('post', 'comments'));
        }
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

        if($this->agent->isMobile()) {
            return view('mobile.post.create', compact('channels', 'post'));
        } else {
            return view('post.create', compact('channels', 'post'));
        }
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
        // set validation rules
        $rules = [
            'channelID' => 'required',
            'title' => 'min:1|required|max:200',
            'content' => 'min:1|required',
        ];

        $messages = [
            'channelID.required' => '채널을 선택해주세요.',
            'title.required' => '제목을 입력해주세요.',
            'content.required' => '내용을 입력해주세요.',
            'title.max' => '제목은 최대 255 글자 이하입니다.',
            'content.min' => '내용은 최소 1 글자 이상 입력해주세요.',
            'title.min' => '제목은 최소 1 글자 이상 입력해주세요.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

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

        Post::where('id', $id)
            ->update([
                'image'=>$mainImageUrl,
                'title'=>$request->title,
                'channelID'=>$request->channelID,
                'content'=>$content
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
        $id = $req->input('id'); //postID
        $like = $req->input('like');

        // 수정 및 생성
        $post = Post::find($id);
        $checkExistValue = $post->likes()
            ->where('like', $like)
            ->where('userID', auth()->id())
            ->first();

        if ($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
        } else {
            $result = $post->likes()->updateOrCreate(
                ['userID' => auth()->id()],
                ['like' => $like, 'userID' => auth()->id()]
            );
        }
        // 결과
        if ($result) {
            $totalLike = $post->likes->sum('like');
            return response()->json(['totalLike' => $totalLike, 'like' => $post->existPostLike]);
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
