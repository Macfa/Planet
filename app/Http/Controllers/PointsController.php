<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Point;

class PointsController extends Controller
{
    public function earn($memberID, $pointTypeID) {
        // Earn Point function 
        Point::create([
            'memberID' => $memberID,
            'pointTypeID' => $pointTypeID
        ]);
    }

    public function spend($memberID, $pointTypeID) {
        Point::where('memerID', '=', $memberID)
            ->get()
            ;
    }

    public function get($memberID) {
        // get point you have
    }
}
