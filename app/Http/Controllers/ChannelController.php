<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Favorite;
use App\Models\Post;
use Illuminate\Http\Request;

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
        $created = Channel::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'userID' => auth()->id()
        ]);

        $channel = Channel::find($created->id);
        $channel->favorites()->create([
            'userID' => auth()->id(),
            'channelID' => $created->id
        ]);

        // return back()->withInput();
        return redirect()->route('channel.show', $created->id);
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
        $updatedChannel = Channel::where('id', $id)
            ->update([
                'name' => $request->name,
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

        return redirect()->route('home');
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

