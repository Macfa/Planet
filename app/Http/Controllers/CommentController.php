<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

//        dd($request);
        $id = $request->input('id'); // 그룹 아이디

        if($id == null) {
            // 첫 댓글의 경우
//            $result = $this->storeFirst($request);
            $createdCommentID = $this->storeComment($request);
        } else {
            // 대댓글의 경우
            $createdCommentID = $this->storeReply($request);
        }

        if($createdCommentID) {
            $result = $this->getComment($createdCommentID);
//            dd($result);
            return $result;
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function storeComment(Request $req) {
        // 댓글
        $created = Comment::create([
            'postID' => $req->input('postID'),
            'group' => $req->input('postID'),
            'content' => $req->input('content'),
            'userID' => auth()->id()
        ]);

        if($created->exists) {
            $checkUpdated = Comment::where('id', '=', $created->id)
                ->update([
                    'group' => $created->id
                ]);

            return $created->id;
        } else {
            $result = null;
        }
        return $result;
    }

    public function storeReply(Request $req) { // 대댓글
        $thatComment = Comment::where('id', $req->input('id'))
            ->select('depth', 'order')
            ->get()
            ->first();

        $thatCommentOrder = Comment::where('group', '=', $req->input('group'))
            ->where('order', '>=', $thatComment['order']+1)
            ->increment('order', 1);

        $created = Comment::create([
            'postID' => $req->input('postID'),
            'group' => $req->input('group'),
            'content' => $req->input('content'),
            'depth' => $thatComment['depth']+1,
            'order' => $thatComment['order']+1,
            'userID' => auth()->id()
        ]);
        if($created->exists) {
            return $created->id;
        } else {
            return null;
        }
    }
    public function getComment($id) {
        $comment = Comment::with('user')
            ->with('likes')
            ->find($id);

        // modify a necessary data
        $comment->created_at_modi = $comment->created_at->diffForHumans();
        $comment->sumOfVotes = $comment->likes->sum('vote');

        return $comment;
    }

    public function voteLikeInComment(Request $req)
    {
        // 이력 확인
        $id = $req->input('id');
        $vote = $req->input('vote');

        // 수정 및 생성
        $comment = Comment::find($id);
        $checkExistValue = $comment->likes()
            ->where('vote', $vote)
            ->first();

        if ($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
        } else {
            $result = $comment->likes()
                ->updateOrCreate([
                    'userID' => auth()->id()
                ], [
                    'vote' => $vote,
                    'userID' => auth()->id()
                ])->exists;
        }

        // 결과
        if ($result) {
            $totalVote = $comment->likes->sum('vote');
            return response()->json(['vote' => $totalVote]);
        }
    }
}
