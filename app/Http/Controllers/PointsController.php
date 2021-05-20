<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Point;

class PointsController extends Controller
{
    public function use($memberID, $pointTypeID) {
        // Earn Point function 
        Point::create([
            'memberID' => $memberID,
            'pointTypeID' => $pointTypeID
        ]);
    }

    public function get($memberID) {
        // get point you have
    }
}
