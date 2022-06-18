<?php

namespace App\Http\Controllers;

use App\Models\CoinSetup;
use App\Models\Post;
use App\Models\Stamp;
use App\Models\StampCategory;
use App\Models\StampGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    function index() {
        return view('admin.index');
    }

    function report() {
        $posts = Post::join('reports', 'posts.id', '=', 'reportable_id')
            ->select(DB::raw('*, count(*) AS totalCount'))
            ->groupby(['reports.reportable_id', 'reports.reportable_type'])
            ->orderby('reports.reportable_id', 'desc')
            ->get();
        //    ->toSql();dd($posts);

        return view('admin.report', compact('posts'));
    }
    function coin() {
        $coin_setup = CoinSetup::find(1);

        return view('admin.coin', compact('coin_setup'));
    }
    function setCoin(Request $request) {
        // set validation rules
        $rules = [
            'post' => 'required|integer|min:0',
            'comment' => 'required|integer|min:0',
            'post_limit' => 'required|integer|min:0',
            'comment_limit' => 'required|integer|min:0',
        ];

        $messages = [
            'post' => '글 작성 시, 포인트를 입력해주세요.',
            'comment' => '댓글 작성 시, 포인트를 입력해주세요.',
            'post_limit' => '게시글 일일 최대 포인트 획득 제한 수를 입력해주세요.',
            'comment_limit' => '댓글 일일 최대 포인트 획득 제한 수를 입력해주세요.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $setup = CoinSetup::updateOrCreate([
            'id'=>1
        ],[
            'post'=>$request->input("post"),
            'comment'=>$request->input("comment"),
            'post_limit'=>$request->input("post_limit"),
            'comment_limit'=>$request->input("comment_limit"),
            'updated_at'=>now(),
        ]);
        return redirect('/admin/coin')->with([
            'msg' => '수정되었습니다',
            'status' => '200'
        ]);
    }
    function user() {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.user', compact('users'));
    }
    function stampCategory() {
        $categories = StampCategory::all();
        return view('admin.stamp_category', compact('categories'));
    }
    function stampGroup() {
        $groups = StampGroup::all();
        return view('admin.stamp_group', compact('groups'));
    }
    function stamp() {
        $stamps = Stamp::all();
        return view('admin.stamp', compact('stamps'));
    }

}
