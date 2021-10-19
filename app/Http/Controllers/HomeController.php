<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\ChannelVisitHistory;
use App\Models\Coin;
use App\Models\CoinType;
use App\Models\Favorite;
use App\Models\Notification;
use App\Models\PointType;
use App\Models\Post;
use App\Models\User;
use App\Notifications\Alarmnotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::getAllData();

        $channelVisitHistories = ChannelVisitHistory::showHistory();
        return view('main.index', compact('posts', 'channelVisitHistories'));
    }

    public function mainMenu(Request $request) {
//        dd($request->all());
        $type = $request->type;
        $channelID = $request->channelID;
        $page = $request->page;
//        $params = $request->only('type', 'channelID', 'page');
        $posts = Post::mainMenu($type, $channelID, $page);
//        var_dump($posts);
//        dd($posts);

        return response()->json(['result' => $posts]);
    }

    public function sidebar(Request $request) {
        $type = $request->type;

        if($type==='realtime') {
            $posts = Post::with('channel')
                ->with('likes')
                ->orderby('id', 'desc')
                ->limit(5)
                ->get();
        } else if($type==='hot') {
            $posts = Post::with('channel')
                ->with('likes', function($q) {
                    $q->orderby('like', 'desc');
                })
                ->with('comments')
                ->limit(5)
                ->get();
//                ->sortBy;
        }
        foreach($posts as $idx => $post) {
            $posts[$idx]['totalVote'] = $post->likes->sum('vote');
        }
        return response($posts, 200);
//        $posts['like'] = $posts->likes()->sum('vote');
//        return $posts;
    }

    public function search(Request $request) {
        $searchType = $request->get('searchType');

        $searchContent = '%'.$request->searchText.'%';
//        $posts = Post::where('content', 'like', $searchContent)

        $posts = Post::where(function($q) use ($searchType, $searchContent) {
                if($searchType==='a') {
                    $q->where('title', 'like', $searchContent);
                    $q->orWhere('content', 'like', $searchContent);
                } else if($searchType==='t') {
                    $q->where('title', 'like', $searchContent);
                } else if($searchType==='c') {
                    $q->where('content', 'like', $searchContent);
                }
            })
            ->withCount('comments')
            ->with('channel')
            ->with('user')
            ->with('likes')
            ->get();

        // $visit = new Visit();
        $channelVisitHistories = ChannelVisitHistory::showHistory();

        return view('main.search', compact('posts', 'channelVisitHistories', 'searchType'));
    }

    public function searchHelper(Request $request) {
        $searchText = $request->input('searchText');
        $matched = substr($searchText, 0, 1);

        if($matched == "#") {
            // 키워드를 포함하는 동아리 검색
            $tempSearchText = substr($searchText, 1);
            $toSearchText = '%'.$tempSearchText.'%';

            $expectChannel = Channel::where('name', 'like', $toSearchText)
                ->limit(5)
                ->select('image', 'name', 'id')
                ->get();
            $type = "channel";
        } else {
            // 키워드 없는 게시글 검색.
            $toSearchText = '%'.$searchText.'%';

            $expectChannel = Post::where('title', 'like', $toSearchText)
                ->limit(5)
                ->select('title', 'id')
                ->get();
            $type = "post";
        }

        return ["list" => $expectChannel, "type" => $type];
    }

    public function test() {
        $userID = auth()->id();
        $user = User::find($userID);
        $user->coins()->create([
            'coin' => 500,
            'type' => 'test',
            'userID' => $userID
        ]);

        return redirect()->back();
    }

    public function test2() {
        $posts = Post::willRemove();

        $channelVisitHistories = ChannelVisitHistory::showHistory();
        return view('main.index', compact('posts', 'channelVisitHistories'));
    }
}
