<?php

namespace App\Models;

use Carbon\Carbon;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use SoftDeletes, CascadeSoftDeletes, HasFactory;

    protected $table = "experiences";
    protected $primaryKey = "id";
    protected $guarded = [];
//    protected $cascadeDeletes = [];

    public function experienced()
    {
        return $this->morphTo('experienced', 'experienced_type', 'experienced_id');
    }
    public function writePost(Post $post) {
        $today = Carbon::now();
        $coin_setup = CoinSetup::findOrFail(1);
        $limit = $coin_setup->post_limit;

        if(!auth()->check()) {
            return abort(401);
        }
        $user = auth()->user();
        $totalExp = $user->hasExperiences("post")->whereDate('coins.created_at', $today)->sum('exp');
//        $totalExp = $post->experiences()->whereDate('experiences.created_at', $today)->sum('exp');

        if($totalExp > $limit) {
            // 코인 추가 획득 불가
            return true;
        } else {
            $post->experiences()->create([
                'message'=> '글작성',
                'exp'=> $coin_setup->post,
                'user_id'=> auth()->id()
            ]);
            $this->checkUserGrade();
            // 코인 추가 획득
        }
    }

    public function writeComment(Comment $comment) {
        $today = Carbon::now();
        $coin_setup = CoinSetup::findOrFail(1);
        $limit = $coin_setup->comment_limit;

        if(!auth()->check()) {
            return abort(401);
        }
        $user = auth()->user();
        $totalExp = $user->hasExperiences("comment")->whereDate('coins.created_at', $today)->sum('exp');
//        $totalExp = $comment->experiences()->whereDate('experiences.created_at', $today)->sum('exp');

        if($totalExp > $limit) {
            // 코인 추가 획득 불가
        } else {
            $comment->experiences()->create([
                'message'=> '댓글작성',
                'exp'=> $coin_setup->comment,
                'user_id'=> auth()->id()
            ]);
            $this->checkUserGrade();
            // 코인 추가 획득
        }
    }

    public function checkUserGrade() {
        $checkExistGradeTable = DB::table("grades")->exists();

        if(!$checkExistGradeTable) {
//            $grade = new Grade();
//            $grade->setDefaultValue();
        }
        $user = User::find(auth()->id());
//        dd($user->grade);
        $totalExp = $user->hasExperiences()->sum('exp');
//        dd($user);
        $maxExp = $user->grade->maxExp;
        $minExp = $user->grade->minExp;

        if($maxExp > $totalExp && $minExp < $totalExp) {
            // pass
        } else if($maxExp <= $totalExp) {
            $level = Grade::where('minExp', '<=', $totalExp)->where('maxExp', '>', $totalExp)->value('level');
            $user->level = $level;
            $user->save();
//            $request->session()->flash('status', 'Task was successful!');
        } else if($minExp > $totalExp) {
            // pass
        }
    }
}
