<?php

namespace App\Http\Controllers\channel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function create() {
        return view('/channel/create');
    }
}
