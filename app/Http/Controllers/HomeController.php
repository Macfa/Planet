<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

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

        $coin = User::where('id', auth()->id())
            ->with('coins')
            ->with('coins.coinType')
//            ->sum('coin_type.coin');
        ->get();
//        dd($coin);
        // $posts = json_decode($posts);
        // ddd($posts);
        // $favorites = json_decode($favorites);
        return view('main.index', compact('posts', 'favorites'));
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
}
