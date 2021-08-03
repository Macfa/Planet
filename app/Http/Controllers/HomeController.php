<?php

namespace App\Http\Controllers;

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
        $posts = Post::withCount('comments')
            ->with('channel')
            ->with('user')
            ->with('likes')
            ->orderby('id', 'desc')
            ->get();

        $favorites = Favorite::where('userID', '=', auth()->id())
            ->with('channel')
            ->orderby('id', 'desc')
            ->get();

//        $coin = User::where('users.id', auth()->id())
//            ->join('coins', 'users.id', '=', 'coins.userID')
//            ->join('coin_types', 'coin_types.id', '=', 'coins.coinTypeID')
//            ->sum('coin_types.coin');
        // $posts = json_decode($posts);
        // ddd($posts);
        // $favorites = json_decode($favorites);
//        return view('main.index', compact('posts', 'favorites', 'coin'));
        return view('main.index', compact('posts', 'favorites'));
    }

    public function mainmenu(Request $request) {
        $type = $request->type;

        if($type==='realtime') {
            $posts = Post::with('channel')
                ->with('likes')
                ->limit(5)
                ->orderBy('id', 'desc')
                ->get();

        } else if($type==='hot') {
            $posts = Post::with('channel')
                ->with('likes')
                ->with('comments')
                ->limit(5)
                ->orderBy('likes.vote')
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

        $favorites = Favorite::where('userID', '=', auth()->id())
            ->with('channel')
            ->orderby('id', 'desc')
            ->get();

        return view('main.index', compact('posts', 'favorites', 'searchType'));
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
