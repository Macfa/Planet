<?php

namespace App\Http\Controllers;

use App\Models\Coin;
use App\Models\Comment;
use App\Models\Experience;
use App\Models\User;
use App\Notifications\NoticeChannel;
use App\Notifications\Noticenotification;
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
        if(auth()->id() == null) {
            return response()->json(['reason'=>'login'], 401);
        }
        $id = $request->input('id'); // 그룹 아이디

//        dd($request->input('content'));

        if($id == null) {
            // 첫 댓글의 경우
//            $result = $this->storeFirst($request);
            $createdCommentID = $this->storeComment($request);
        } else {
            // 대댓글의 경우
            $createdCommentID = $this->storeReply($request);
        }

        if($createdCommentID) {
            // 작성된 댓글 js 로 붙이기 위해 데이터 호출함수
            $result = $this->getComment($createdCommentID);

            $comment = Comment::find($createdCommentID);
            $coin = new Coin();
            $experience = new Experience();
            $coin->writeComment($comment);
            $experience->writeComment($comment);

            $postUserID = $result->post->userID;
            $user = User::find($postUserID);
            $user->notify(new Noticenotification($result));

            return $result;
        } else {
            return redirect(["reason"=>""])->back();
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
//        $post = Comment::find($id);
//        $channels = Channel::get();
//
//        return view('post.create', compact('channels', 'post'));
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
        $comment = Comment::find($id);
        $comment->content = $request->input('content');
        $comment->save();

        $result = $this->getComment($id);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::where('id', $id)
            ->delete();

        return true;
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
            ->first();

        $thatCommentOrder = Comment::where('group', '=', $req->input('group'))
            ->where('order', '>=', $thatComment['order']+1)
            ->increment('order', 1);

        $created = Comment::create([
            'postID' => $thatComment['postID'],
            'group' => $thatComment['group'],
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
        $commentCount = Comment::where('postID', $comment->postID)
            ->count();

        // modify a necessary data
        $comment->updated_at_modi = $comment->updated_at->diffForHumans();
        $comment->sumOfVotes = $comment->likes->sum('vote');
//        dd($comment->post());
        $comment->commentCount = $commentCount;
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
            ->where('userID', auth()->id())
            ->first();

        if ($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
        } else {
            $result = $comment->likes()->updateOrCreate(
                ['userID' => auth()->id()],
                ['vote' => $vote, 'userID' => auth()->id()]
            );
        }

        // 결과
        if ($result) {
            $totalVote = $comment->likes->sum('vote');
            return response()->json(['totalVote' => $totalVote, 'vote' => $comment->existCommentLike]);
        }
    }
}
