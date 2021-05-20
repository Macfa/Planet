<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Favorite;

class MainController extends Controller
{
    //
    public function index() {
        $posts = Post::withCount('comments')
            ->with('channel')
            ->with('user')
            ->where('posts.hide', '=', '0')
            ->get()
            ->toJson();

        $favorites = Favorite::where('memberID', '=', auth()->id())
            ->with('channel')
            ->orderby('id', 'desc')
            ->get()
            ->toJson();

        $posts = json_decode($posts);
        $favorites = json_decode($favorites);
        return view('main.index', compact('posts','favorites'));
    }

    public function search(Request $req) {
        [$results, $el] = $this->searchProccess($req);
        
        $results = json_decode($results);
        // dd($results);
        return view('main.result', compact('results', 'el'));
    }
    public function searchProccess($req) {
        $el = $req->input('searchType');
        if($el === null) {
            $el = 't';
        }
        if($el == 'tc') {
            $whereObj = Post::where('title', 'like', '%'.$req->input('searchText').'%')
                ->orWhere('content', 'like', '%'.$req->input('searchText').'%');
        } else if($el == 't') {
            // $whereObj = Post::whereLike('title', $req->input('searchText'));
            $whereObj = Post::where('title', 'like', '%'.$req->input('searchText').'%');
        } else if($el == 'c') {
            $whereObj = Post::where('content', 'like', '%'.$req->input('searchText').'%');
        }

        // last Process 
        $whereObj = $whereObj->withCount('comments')
            ->with('channel')
            ->with('user')
            ->get()
            ->toJson();

        return [$whereObj, $el];
    }
}
