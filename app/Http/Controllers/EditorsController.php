<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorsController extends Controller
{
    public function upload(Request $request) {
    //    dd($request);
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

            if($request->hasFile('upload')) {
                $request->file($target)->move(public_path('upload'), $fileName);
                $url = asset('upload/'.$fileName);
                $msg = 'File uploaded successfully';
            } else {
                $request->file($target)->move(public_path('image'), $fileName);
                $url = asset('image/'.$fileName);
                $msg = 'Image uploaded successfully';
            }

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');


            $result = [
                'url' => $url,
                'msg' =>  $msg,
            ];
            return $result;
        }
    }
}
