<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\storePostReqeust;
use App\Services\Front\ChannelService;
use App\Services\Front\PostService;
use App\Services\Front\CommentService;
use App\Services\Front\ChannelVisitHistoryService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $channelService;
    protected $postService;
    protected $commentService;
    protected $channelVisitHistoryService;
    public function __construct(ChannelService $channelService, PostService $postService, CommentService $commentService, ChannelVisitHistoryService $channelVisitHistoryService)
    {
        $this->channelService = $channelService;
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->channelVisitHistoryService = $channelVisitHistoryService;
    }
    public function create()
    {
        // dd('allChannels');
        $allChannels = $this->channelService->getAllForUser(auth()->id());
        // dd($allChannels);
        $setting = [
            'type' => 'create',
            "btn" => "등록",
        ];
        return view('post.create', compact('setting', 'allChannels'));
    }
    public function store(storePostReqeust $request)
    // public function store(Request $request)
    {
        try {
            $validated_data = $request->validated();
            $validated_data['user_id'] = auth()->id();
            // dd($validated_data);
            $this->postService->createPost($validated_data);
            return redirect('/');
        } catch(\Exception $e) {
            // dd($e->getMessage());  
            return back()->withErrors(['msg' => '글 등록에 실패했습니다. 다시 시도해주세요.'])->withInput();
        }
    }
    public function edit()
    {
        //
    }
    public function show(int $id)
    {
        // dd($id);
        $post = $this->postService->getPost($id);
        $posts = $this->postService->getPosts();
        $comments = $this->commentService->getCommentsByPostId($id);
        $channelVisitHistories = $this->channelVisitHistoryService->recent();

        $compactValue = compact('post', 'comments', 'posts', 'channelVisitHistories');
// dd($compactValue);
        // return view('post.show', $compactValue);
        return view('post.get', $compactValue);
    }
}