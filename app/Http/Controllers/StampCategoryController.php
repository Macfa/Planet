<?php

namespace App\Http\Controllers;

use App\Models\Stamp;
use App\Models\StampCategory;
use Illuminate\Http\Request;

class StampCategoryController extends Controller
{
    function get(Request $request) {
        $categoryId = $request->input("categoryId");

        if($categoryId === "0") {
            $getCategory = Stamp::all();
        } else {
            $getCategory = Stamp::where('id', $categoryId)->get();
        }
//        dd($categoryId, $getCategory);
        return $getCategory;
    }
}
