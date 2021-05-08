<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    public function store(Request $req) {
        $id = $req->input('id'); // 그룹 아이디
        if($id == null) {
            // 첫 댓글의 경우
            $this->storeFirst($req);
        } else {
            // 대댓글의 경우
            $this->storeLast($req);
        }

        return back()->withInput();
    }

    public function storeFirst($req) {
        $comments = Comment::create([
            'postID' => $req->input('postID'),
            'group' => $req->input('postID'),
            'content' => $req->input('content'),
            'parent' => $req->input('id'),
            'memberID' => auth()->id(),
            'like' => 0,
            'hate' => 0,
            'hide' => 0,
            'order' => 1,
            'depth' => 0
        ]);
        Comment::where('id', '=', $comments->id)
            ->update([
                'group' => $comments->id
            ]);
    }

    public function storeLast($req) {
        $depth = Comment::where('id', '=', $req->input('id'))
            ->value('depth');

        $order = Comment::where('group', '=', $req->input('group'))
            ->where('parent', '=', $req->input('id'))
            ->where('depth', '=', $depth+1)
            ->max('order');
            // ->update([
            //     'order' => $valAsIS['order']+1
            // ]);
        // dd($order+1);

        $comments = Comment::create([
            'postID' => $req->input('postID'),
            'group' => $req->input('group'), // group or id
            'parent' => $req->input('id'),
            'content' => $req->input('content'),
            'depth' => $depth+1,
            'order' => $order+1,
            'memberID' => 1
        ]);

            // ->get()
            // ->first();
            // dd($comments);
            // ->update([
            //     'depth' => $val['depth']+1
            // ]);
    }

    public function upvote($id) {
        Comment::where('id', '=', $id)
            ->increment('like',1);

        $result = Comment::where('id', '=', $id)
            ->get()
            ->first();

        return response()->json($result);
    }
}
