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
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    private $content = '';
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
            abort(401);
        }
        $id = $request->input('id'); // 그룹 아이디
        $this->content = preg_replace('/\r\n|\r|\n/',PHP_EOL,$request->input("content"));

        if($id == null) {
            // 첫 댓글의 경우
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

            $postUserID = $result->post->user_id;
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
            'post_id' => $req->input('post_id'),
            'group' => $req->input('post_id'),
            'content' => $this->content,
            'target_id' => null,
            'user_id' => auth()->id()
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
            'post_id' => $thatComment['post_id'],
            'group' => $thatComment['group'],
            'content' => $this->content,
            'target_id' => $thatComment->user_id,
            'score' => $thatComment['score'],
            'depth' => $thatComment['depth']+1,
            'order' => $thatComment['order']+1,
            'user_id' => auth()->id()
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
        $commentCount = Comment::where('post_id', $comment->post_id)
            ->count();

        // modify a necessary data
        $comment->updated_at_modi = $comment->updated_at->diffForHumans();
        $comment->sumOfLikes = $comment->likes->sum('like');
        $comment->commentCount = $commentCount;
        $comment->target_name = ( $comment->targetUser ) ? $comment->targetUser->name : "";

        return $comment;
    }

    public function like(Comment $comment)
    {
        if(!auth()->check()) {
            return response("로그인이 필요한 기능입니다", 401);
        }

        // 이력 확인
        $like = request()->input('like');

        // 수정 및 생성
        $checkExistValue = $comment->likes()
            ->where('like', $like)
            ->where('user_id', auth()->id())
            ->first();

        if ($checkExistValue != null) {
            $result = $checkExistValue->delete(); // get bool
            $totalLike = $comment->likes()->where('like', 1)->sum('like');
            if($like !== -1) {
                if($comment->target_id && $comment->target_id !== auth()->id()) {
                    // 대댓글의 경우이고 원본 댓글이 본인 댓글이 아닌 경우
                    // 대댓글에 스코어 점수를 업데이트한다.
                    if($totalLike >= 2) {
                        $targetComment = Comment::where('group', '=', $comment->group);
                        $targetComment->update(['score' => DB::raw('score - 1')]);
                    }
                } else if($comment->user_id !== auth()->id()) {
                    // 댓글이 내가 작성한 것이 아닌 경우
                    // 댓글 의 스코어 점수를 업데이트 한다
                    if($totalLike >= 2) {
                        $targetComment = Comment::where('group', '=', $comment->group);
                        $comment->update(['score' => DB::raw('score - 1')]);
                    }
                }
            }
        } else {
            $type = $comment->likes()
            ->where('user_id', auth()->id())
            ->first();

            // 댓글에 선택된 좋아요 가 없는 경우
            $result = $comment->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['like' => $like, 'user_id' => auth()->id()]
            );

            if($like !== -1) {
                if(!$type) {
                    $totalLike = $comment->likes()->where('like', 1)->sum('like');
                    if($comment->target_id && $comment->target_id !== auth()->id()) {
                        if($totalLike >= 2) {
                            $targetComment = Comment::where('group', '=', $comment->group);
                            $targetComment->update(['score' => DB::raw('score + ' . $like)]);
                        }
                    } else if($comment->user_id !== auth()->id()) {
                        if($totalLike >= 2) {
                            $targetComment = Comment::where('group', '=', $comment->group);
                            $targetComment->update(['score' => DB::raw('score + ' . $like)]);
                            // $comment->update(['score' => DB::raw('score + ' . $like)]);
                        }
                    }
                }
            }
        }

        // 결과
        if ($result) {
            $totalLike = $comment->likes->sum('like');
            return response(['totalLike' => $totalLike, 'like' => $comment->existCommentLike], 200);
        } else {
            return response('', 500);
        }
    }
}
