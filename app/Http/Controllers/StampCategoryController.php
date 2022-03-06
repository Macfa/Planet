<?php

namespace App\Http\Controllers;

use App\Models\Stamp;
use App\Models\StampCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StampCategoryController extends Controller
{
    public function store(Request $request) {
        // set validation rules
        $rules = [
            'name' => 'required',
        ];

        $messages = [
            'required' => ':attribute 입력해주세요.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        // some work with image

        // upload file
        $upload_controller = new EditorsController();
//        $result = $upload_controller->upload($request);

//        if($result) {
            StampCategory::create([
                'name' => $request->input("name"),
//                'image' => $result["url"]
            ]);
//        }
        return redirect()->to('/admin/stampCategory');
    }

    public function destroy($id) {
        $category = StampCategory::findOrFail($id);
        $category->delete();

        return redirect()->back();
    }

    function get(Request $request) {
        $categoryId = $request->input("categoryId");

        if($categoryId === "0") {
            $getCategory = Stamp::all();
        } else {
            $getCategory = Stamp::where('category_id', $categoryId)->get();
        }

        return $getCategory;
    }
}
