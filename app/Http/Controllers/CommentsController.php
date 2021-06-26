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
            $result = $this->storeFirst($req);
        } else {
            // 대댓글의 경우
            $result = $this->storeLast($req);
        }

        if($result) {
            return response()->json($result);
        } else {
//            return false;
//            exit;
            return null;
        }
    }

    public function storeFirst($req) {
        // 댓글
        $created = Comment::create([
            'postID' => $req->input('postID'),
            'group' => $req->input('postID'),
            'content' => $req->input('content'),
            'memberID' => auth()->id()
        ]);

        if($created->exists) {
            $checkUpdated = Comment::where('id', '=', $created->id)
                ->update([
                    'group' => $created->id
                ]);

            $result = [
                'result' => 'suc'
            ];

        } else {
            $result = null;
        }
        return $result;
    }

    public function storeLast($req) { // 대댓글
        $thatComment = Comment::where('id', $req->input('id'))
            ->select('depth', 'order')
            ->get()
            ->first();

        $thatCommentOrder = Comment::where('group', '=', $req->input('group'))
            ->where('order', '>=', $thatComment['order']+1)
            ->increment('order', 1);

//        dd($thatCommentDepth);
        $comment = Comment::create([
            'postID' => $req->input('postID'),
            'group' => $req->input('group'),
            'content' => $req->input('content'),
            'depth' => $thatComment['depth']+1,
            'order' => $thatComment['order']+1,
            'memberID' => auth()->id()
        ]);
    }

    public function voteLikeInComment(Request $req) {
        // 이력 확인
        $id = $req->input('id');
        $vote = $req->input('vote');

        // 수정 및 생성
        $comment = Comment::find($id);
        $checkExistValue = $comment->likes()
            ->where('like', $vote)
            ->first();

        if($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
        } else {
            $result = $comment->likes()
                ->updateOrCreate([
                    'memberID'=>auth()->id()
                ], [
                    'like' => $vote,
                    'memberID'=>auth()->id()
                ])->exists;
        }

        // 결과
        if($result) {
            $totalVote = $comment->likes->sum('like');
            return response()->json(['like' => $totalVote]);
        }
    }
}
