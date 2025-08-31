<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Http\Requests\storePostReqeust;
use App\Services\Front\ChannelService;
use App\Services\Front\PostService;
use Illuminate\Support\Facades\Request;

class PostController extends Controller
{
    protected $channelService;
    protected $postService;
    public function __construct(ChannelService $channelService, PostService $postService)
    {
        $this->channelService = $channelService;
        $this->postService = $postService;
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
    {
        $validated_data = $request->validated();
        $validated_data['user_id'] = auth()->id();
        try {
            $this->postService->createPost($validated_data);
            return redirect('/');
        } catch(\Exception $e) {
            return back()->withErrors(['msg' => '글 등록에 실패했습니다. 다시 시도해주세요.'])->withInput();
        }
    }
    public function edit()
    {
        //
    }
}