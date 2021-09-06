<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Favorite;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
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
        return view('channel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // set validation rules
        $rules = [
            'name' => 'required|unique:channels|max:100|min:2',
            'description' => 'required|max:255|min:2',
        ];

        $messages = [
            'name.required' => '동방명을 입력해주세요.',
            'description.required' => '동방 소개란을 입력해주세요.',
            'name.min' => '동방명은 최소 2 글자 이상입니다.',
            'description.min' => '동방 소개란은 최소 2 글자 이상입니다.',
            'name.max' => '동방명은 최대 255 글자 이하입니다.',
            'description.max' => '동방 소개란은 최대 255 글자 이하입니다.',
            'name.unique' => '동방명이 이미 사용 중입니다.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();


        $created = Channel::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'userID' => auth()->id()
        ]);

        $channel = Channel::findOrFail($created->id);
        $channel->favorites()->create([
            'userID' => auth()->id(),
            'channelID' => $created->id
        ]);

        // return back()->withInput();
        return redirect()->route('channel.show', $created->id)->with(['msg'=>'동아리가 생성되었습니다.', 'type'=>'info']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get all of posts with channels
        $posts = Post::with('channel')
            ->withCount('comments')
            ->with('user')
            ->with('likes')
            ->where("posts.channelID",$id)
            ->orderby('id', 'desc')
            ->get();

        // favorite info
        $favorites = Favorite::where('userID', '=', auth()->id())
            ->with('channel')
            ->orderby('id', 'desc')
            ->get();

        // channel info
        $channel = Channel::where('id', $id)
            ->withCount('favorites')
            ->get()
            ->first();

        return view('channel.show', compact('posts', 'channel', 'favorites'));
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
    public function destroy($id)
    {
        Channel::where('id', $id)
            ->delete();

        return true;
    }

    public function favorite(Request $req) {
        $id = $req->input('id');

        $exist = Favorite::where('channelID', $id)
            ->where('userID', '=', auth()->id())
            ->first();

        if($exist != null) {
            Favorite::where('channelID', $id)
                ->where('userID', auth()->id())
                ->delete();

            $result = array();
            $result['id'] = $id;
            $result['result'] = 'deleted';

        } else {
            $created = Favorite::create([
                'userID' => auth()->id(),
                'channelID' => $id
            ]);

            $result = Favorite::where('id', '=', $created->id)
                ->with('channel')
                ->first();
            $result['result'] = 'created';
        }

        $count = Favorite::where('channelID', $id)
            ->count();
        $result['totalCount'] = $count;
        return response()->json($result, 200);
    }
}

