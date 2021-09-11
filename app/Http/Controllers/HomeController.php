<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\CoinType;
use App\Models\Favorite;
use App\Models\Notification;
use App\Models\PointType;
use App\Models\Post;
use App\Models\User;
use App\Models\Visit;
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
        $posts = Post::withCount('comments')
            ->with('channel')
            ->with('user')
            ->with('likes')
            ->orderby('id', 'desc')
            ->pagination()
            ->get();

        $visit = new Visit();
        $visits = $visit->showHistory();
        return view('main.index', compact('posts', 'visits'));
    }
    public function getDataFromScrolling(Request $request) {
        if($request->ajax()) {

        }
    }

    public function mainmenu(Request $request) {
        $type = $request->type;
        $channelID = $request->channelID;
        $page = $request->page;

        if($type==='realtime') {
            $posts = Post::with('channel')
                ->with('likes')
                ->with('user')
                ->withCount('comments')
                ->orderby('id', 'desc')
                ->where(function($query) use ($channelID) {
                    if($channelID) {
                        $query->where('channelID', '=', $channelID);
                    }
                })
                ->pagination($page)
                ->get();
        } else if($type==='hot') {
            $posts = Post::with('channel')
                ->with('likes', function($q) {
                    $q->orderby('vote', 'desc');
                })
                ->withCount('comments')
                ->with('user')
                ->where(function($query) use ($channelID) {
                    if($channelID) {
                        $query->where('channelID', '=', $channelID);
                    }
                })
                ->limit(5)
                ->get();
        }

        foreach($posts as $idx => $post) {
            $posts[$idx]['totalVote'] = $post->likes->sum('vote');
            $posts[$idx]['created_at_modi'] = $post->created_at->diffForHumans();
        }

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
                    $q->orderby('vote', 'desc');
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

        $visit = new Visit();
        $visits = $visit->showHistory();

        return view('main.search', compact('posts', 'visits', 'searchType'));
    }

    public function test() {
        $s = new Coin();
        $result = $s->purchaseStamp();
        if($result) {
            return back()->with('success', '처리 됨ㅋ');
        } else {
            return back()->with('error', '포인트가 충분하지않아ㅋ');
        }
    }

    public function test2() {
        $user = User::find(auth()->id());
        $post = Post::find(1);

        $user->notify(new Alarmnotification($post));
    }
}
