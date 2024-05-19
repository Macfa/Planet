<?php

namespace App\Http\Controllers;

use App\Models\ChannelVisitHistory;
use App\Models\Coin;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use App\Models\Visit;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class UserController extends Controller
{

    private Agent $agent;
    protected userService $userService;

    public function __construct(UserService $userService)
    {
        $this->checkAgent();
        $this->userService = $userService;
    }
    public function checkAgent() {
        $this->agent = new Agent();
        if($this->agent->isMobile()) {
            redirect('http://m.localhost:8000/');
        }
    }
    public function show(User $user, $el = 'post') {
        [$posts, $channelVisitHistories, $coin] = $this->userSerivce->getData($user, $el);

        if($this->agent->isMobile()) {
            return view('mobile.user.show', compact('posts', 'channelVisitHistories', 'user', 'coin', 'el'));
        } else {
            return view('user.show', compact('posts', 'channelVisitHistories', 'user', 'coin', 'el'));
        }
    }

    public function modify(Request $request, $id) {
        $user = User::find($id);
        $name = $request->input("name");

        // set validation rules
        $rules = [
            'name' => 'required|min:2|max:50|unique:users',
        ];

        $messages = [
            'name.required' => '이름을 입력해주세요.',
            'name.max' => '이름은 최대 50 글자 이하입니다.',
            'name.min' => '이름은 최소 2 글자 이상입니다.',
            'name.unique' => '동일한 이름이 존재합니다.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $result = $user->changeUserName($name);

        if($result) {
            return redirect()->back()->with(['msg'=>'변경되었습니다', 'type'=>'success']);
        } else {
            return redirect()->back()->with(['msg'=>'코인이 부족합니다', 'type'=>'error']);
        }
    }
    public function destroy() {
        dd(Auth::user());
//        Auth::user()->delete();
    }
    public function logedIn() {
        if(Auth::check()) {
            return true;
        } else {
            return false;
        }
    }

    public function logout(Request $request) {
        $rememberMeCookie = Auth::getRecallerName();
        // Tell Laravel to forget this cookie
        $cookie = Cookie::forget($rememberMeCookie);
        $request->session()->flush();
        $request->session()->regenerate();
        Auth::logout();
        return redirect('/')->with(["msg" => "로그아웃 되었습니다.", "type" => "info"]);
    }
    
}
