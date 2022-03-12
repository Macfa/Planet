<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorsController extends Controller
{
    public function upload(Request $request) {
        dd($request);
        if($request->hasFile('upload') || $request->hasFile('image') ) {
            if($request->hasFile('upload')) {
                $target = 'upload';
            } else {
                $target = 'image';
            }
            $originName = $request->file($target)->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file($target)->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file($target)->move(public_path('image'), $fileName);
//            dd($fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('image/'.$fileName);
            $msg = 'Image uploaded successfully';
            $result = [
                'url' => $url,
                'msg' =>  $msg,
            ];
            return $result;
        }
    }
}
