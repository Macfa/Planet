<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = "experiences";
    protected $primaryKey = "id";
    protected $guarded = [];

    public function experienced()
    {
        return $this->morphTo('experienced', 'experienced_type', 'experienced_id');
    }
    public function writePost(Post $post) {
        $today = Carbon::now();
        $limit = 20;
//        $totalCoin = $post->coins()->where('created_at', $today)->sum('coin');
//        $totalCoin = $post->join('coins', 'coins.coinable_type', '=', 'test')->whereDate('coins.created_at', $today)->sum('coin');
        $totalExp = $post->experiences()->whereDate('experiences.created_at', $today)->sum('exp');

        if($totalExp > $limit) {
            // 코인 추가 획득 불가
        } else {
            $post->experiences()->create([
                'message'=> '글작성',
                'exp'=> 5,
                'user_id'=> auth()->id()
            ]);
            $this->checkUserGrade();
            // 코인 추가 획득
        }
    }

    public function writeComment(Comment $comment) {
        $today = Carbon::now();
        $limit = 10;
        $totalExp = $comment->experiences()->whereDate('experiences.created_at', $today)->sum('exp');

        if($totalExp > $limit) {
            // 코인 추가 획득 불가
        } else {
            $comment->experiences()->create([
                'message'=> '댓글작성',
                'exp'=> 1,
                'user_id'=> auth()->id()
            ]);
            $this->checkUserGrade();
            // 코인 추가 획득
        }
    }

    public function checkUserGrade() {
        $user = User::find(auth()->id());
        $maxExp = $user->grade->maxExp;
        $minExp = $user->grade->minExp;
        $totalExp = $user->hasExperiences()->sum('exp');

        if($maxExp > $totalExp && $minExp < $totalExp) {
            // pass
        } else if($maxExp <= $totalExp) {
            $gradeID = Grade::where('minExp', '<=', $totalExp)->where('maxExp', '>', $totalExp)->value('id');
            $user->gradeID = $gradeID;
            $user->save();
//            $request->session()->flash('status', 'Task was successful!');
        } else if($minExp > $totalExp) {
            // pass
        }
    }
}
