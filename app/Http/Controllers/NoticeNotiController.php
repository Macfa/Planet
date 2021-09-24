<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\Noticenotification;
use Illuminate\Http\Request;

class NoticeNotiController extends Controller
{
    //
    public function test(Request $request) {
        $id = auth()->id();
        $user = User::find($id);
        $comment = Comment::find(91);
        $user->notify(new Noticenotification($comment));
//        dd($user);
    }
    public function test_2() {
        $id = auth()->id();
        $user = User::find($id);
//        return $user->readNotifications();
//        dd($user->notifications);
//        dd($user->readNotifications);
        return redirect()->back()->with(['data' => $user->notifications]);
    }
}
