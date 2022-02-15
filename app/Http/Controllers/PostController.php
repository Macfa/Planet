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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
//        $posts = Post::getAllData();
        $posts = Post::mainMenu('realtime','', 0);
        Gate::check('check-admin', auth()->user());
//        dd($posts);
        $channelVisitHistories = ChannelVisitHistory::showHistory();

        if($this->agent->isMobile()) {
//            dd(1);
            return view('mobile.main.index', compact('posts', 'channelVisitHistories'));
        } else {
            return view('main.index', compact('posts', 'channelVisitHistories'));
        }
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
//        $fromChannelID = $request->input('channel_id');
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
            'channel_id' => $request->input('channel_id'),
            'image' => $mainImageUrl,
            'title' => $request->input('title'),
            'content' => $content,
            'user_id' => auth()->id()
        ])->id;


        // 포인트 추가
        $post = Post::find($id);
//        $post->saveCoinForWritePost();
//        dd($post->coins());
        $coin = new Coin();
        $experience = new Experience();

        $coin->writePost($post);
        $experience->writePost($post);

        $redirect = $request->input('channel_id');
        return redirect()->route('channel.show', $redirect)->with(["status"=>"success", "message"=>"생성되었습니다"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
//        $posts = $post->getAllData();
        $posts = Post::mainMenu('realtime','', 0);

        $channelVisitHistories = ChannelVisitHistory::showHistory();
        if($this->agent->isMobile()) {
            return view('mobile.main.index', compact('posts', 'channelVisitHistories'));
        } else {
            return view('main.index', compact('posts', 'channelVisitHistories'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update',$post);
//        $post = Post::find($id);
        $user = auth()->user();
        if($this->agent->isMobile()) {
            return view('mobile.post.edit', compact('user', 'post'));
        } else {
            return view('post.edit', compact('user','post'));
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
        $post = Post::find($id);
        $this->authorize('update',$post);
        // set validation rules
        $rules = [
            'channel_id' => 'required',
            'title' => 'min:1|required|max:20',
            'content' => 'min:1|required',
        ];

        $messages = [
            'channel_id.required' => '채널을 선택해주세요.',
            'title.required' => '제목을 입력해주세요.',
            'content.required' => '내용을 입력해주세요.',
            'title.max' => '제목은 최대 20 글자 이하입니다.',
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
                'channel_id'=>$request->channel_id,
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

        return response();
//        return true;
    }
    public function like(Post $post)
    {
        if(!auth()->check()) {
            return response("로그인이 필요한 기능입니다", 401);
        }
        // 이력 확인
        $like = request()->input('like');

        // 수정 및 생성
        $checkExistValue = $post->likes()
            ->where('like', $like)
            ->where('user_id', auth()->id())
            ->first();

        if ($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
        } else {
            $result = $post->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['like' => $like, 'user_id' => auth()->id()]
            );
        }
        // 결과
        if ($result) {
            $totalLike = $post->likes->sum('like');
            return response()->json(['totalLike' => number_transform($totalLike), 'like' => $post->existPostLike]);
        }
    }

    public function report(Post $post) {
        if(!auth()->check()) {
            return response("로그인이 필요한 기능입니다", 401);
        }
        if($post->report()->exists()) {
            return response("이미 신고된 글입니다");
        } else {
            $post->report()->create([
                'user_id' => auth()->id(),
                'message' => 'report'
            ]);
            return response("신고되었습니다");
        }
    }
    public function scrap(Post $post) {
//        $postID = $req->id;
//        $post = Post::find($postID);

        if(!auth()->check()) {
            return response("로그인이 필요한 기능입니다", 401);
        }

        $checkExistScrap = $post->scrap()->where('user_id', auth()->id())->first();

        if($checkExistScrap != null) {
            $checkExistScrap->delete();
            $result = "delete";
        } else {
            $post->scrap()->create([
                'user_id' => auth()->id()
            ]);
            $result = "insert";
        }
        return response(['result' => $result]);
    }
    public function getPost(Post $post)
    {
//        $post = Post::where('id', $post->id)->;
        $comments = Comment::where('post_id', '=', $post->id)
            ->with('likes')
            ->with('user')
            ->orderBy('group', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('depth', 'asc')
            ->get();

        if(auth()->check()) {
            // 게시글 열람이력을 추가한다
            $post->postReadHistories()->updateOrCreate(
                ["user_id" => auth()->id() ],
                ['updated_at' => now()]
            );
        }
        if($this->agent->isMobile()) {
            return view('mobile.post.get', compact('post', 'comments'));
        } else {
            return view('post.get', compact('post', 'comments'));
        }
    }
}
