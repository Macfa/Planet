<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Visit;
use Illuminate\Http\Request;

class MobileHomeController extends Controller
{
    public function index()
    {
        $posts = Post::withCount('comments')
            ->with('channel')
            ->with('user')
            ->with('likes')
            ->orderby('id', 'desc')
            ->pagination()
            ->get();

        $visit = new Visit();
        $visits = $visit->showHistory();
        return view('mobile.main.index', compact('posts', 'visits'));
    }
}
