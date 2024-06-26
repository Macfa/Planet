<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\ChannelJoin;
use App\Models\ChannelVisitHistory;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class ChannelController extends Controller
{
    private Agent $agent;

    public function __construct()
    {
        $this->agent = new Agent();
        if($this->agent->isMobile()) {
            redirect('http://m.localhost:8000/');
        }
    }
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
        $this->authorize('create', Channel::class);

        if($this->agent->isMobile()) {
            return view('mobile.channel.create');
        } else {
            return view('channel.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Channel::class);
        $request->name = trim($request->name);

        // set validation rules
        $rules = [
            'name' => 'required|unique:channels|max:40|min:2',
            'description' => 'required|max:255',
        ];

        $messages = [
            'name.required' => '토픽명을 입력해주세요.',
            'description.required' => '토픽 소개란을 입력해주세요.',
            'name.min' => '토픽명은 최소 2 글자 이상입니다.',
//                'description.min' => '토픽 소개란은 최소 2 글자 이상입니다.',
            'name.max' => '토픽명은 40 글자 이하입니다.',
            'description.max' => '토픽 소개란은 최대 255 글자 이하입니다.',
            'name.unique' => '토픽명이 이미 사용 중입니다.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $user = User::find(auth()->id());
        $hasCoin = $user->hasCoins()->sum('coin');
        $toUseCoin = 20;

        if($hasCoin < $toUseCoin) {
            return response()->redirectTo('/')->with(["status"=>"warning", "msg"=>"코인이 부족합니다"]);
        } else {

            // create channel
            $created = Channel::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => auth()->id()
            ]);

            // add favorite
//            $channel = Channel::findOrFail($created->id);
//            $channel->channelJoins()->create([
//                'user_id' => auth()->id(),
//            ]);

            $user->coins()->create([
                "type" => "토픽생성",
                "coin" => -$toUseCoin,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('channel.show', $created->id)->with(["status"=>"success", "message"=>"생성되었습니다"]);
        }
        // return back()->withInput();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        // get all of posts with channels
        // $posts = Post::with('channel')
        //     ->withCount('comments')
        //     ->where("posts.channel_id",$channel->id)
        //     ->where('is_main_notice', 0)
        //     ->orderby('is_channel_notice', 'desc')
        //     ->orderby('id', 'desc')
        //     ->get();

        $posts = Post::mainMenu('realtime', $channel->id);

        // channel info
        $channel = Channel::where('id', $channel->id)
            ->first();

        foreach($posts as $idx => $post) {
            if($post->is_channel_notice === 1) {
                $posts[$idx]['notice'] = true;
            }
        }
        $channelVisitHistories = ChannelVisitHistory::addHistory($channel);

        if($this->agent->isMobile()) {
            return view('mobile.channel.show', compact('posts', 'channel', 'channelVisitHistories'));
        } else {
            return view('channel.show', compact('posts', 'channel', 'channelVisitHistories'));
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
//        dd($id);
        $channel = Channel::find($id);
        return view('channel.create', compact('channel'));
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
            'description' => 'required|max:255',
        ];

        $messages = [
            'required' => ':attribute 입력해주세요.',
            'max' => ':attribute 최대 255 글자 이하입니다.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $updatedChannel = Channel::where('id', $id)
            ->update([
                'description' => $request->description
            ]);

        if($updatedChannel > 0 ) {
            return redirect()->route('channel.show', $id);
//            return response()->json(['result'=>'updated'], 200);
        } else {
            return redirect()->route('home');
//            return response()->json(['result'=>'err'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();
        return true;
    }

    public function channelJoin(Request $req) {
        $id = $req->input('id');

        $exist = ChannelJoin::where('channel_id', $id)
            ->where('user_id', '=', auth()->id())
            ->first();

        if($exist != null) {
            ChannelJoin::where('channel_id', $id)
                ->where('user_id', auth()->id())
                ->delete();

            $result = array();
            $result['id'] = $id;
            $result['result'] = 'deleted';
            $result['type'] = 'info';
            $result['msg'] = '토픽 정상 탈퇴되었습니다';

        } else {
            $created = ChannelJoin::create([
                'user_id' => auth()->id(),
                'channel_id' => $id
            ]);

            $result = ChannelJoin::where('id', '=', $created->id)
                ->with('channel')
                ->first();
            $result['result'] = 'created';
            $result['type'] = 'info';
            $result['msg'] = '토픽 정상 가입되었습니다';
        }

        $count = ChannelJoin::where('channel_id', $id)
            ->count();
        $result['totalCount'] = $count;
        return response()->json($result, 200);
    }
    public function getUserInChannel($channelID) {
        // 이미 추가된 경우 제외
        $data = array();
        $channel = Channel::with('channelJoins')->first();
//        var_dump($channel = Channel::with('channelJoins')->doesntHave('channelAdmins')->getQuery());

        if($channel) {
            foreach($channel->channelJoins as $channelJoin) {
                $data["name"] = $channelJoin->user->name;
            }
            return response()->json($data);
        } else {
            $errorData = [
                "type" => "error",
                "message" => "추가가능한 유저가 없습니다"
            ];
//            return response($errorData, 302);
//            return redirect()->back()->withErrors();
        }
    }
    public function addChannelAdmin(Request $request) {
        $name = $request->input("ChannelJoinInput");
        $channelID = $request->input("channelID");

        if($name) {
            $user = User::with('channelAdmins')->where('name', $name)->first();
            $user->channelAdmins()->create([
                'user_id' => $user->id,
                'channel_id' => $channelID
            ]);
        }
        return redirect()->back();
    }
    function checkOwner(Request $request) {
        $userID = auth()->id();
        $channel = Channel::find($request->input('id'));
        if($userID === $channel->user_id) {
            $result = true;
        } else {
            $result = false;
        }

        return [
            'result' => $result
        ];
        // dd($res, $channel, $channel->is_channel_notice);


    }
    function removeChannelAdmin($userID) {
        $user = User::find($userID);
   }
}

