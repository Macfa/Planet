<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditorsController extends Controller
{
    public function upload(Request $request) {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('image'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('image/'.$fileName);
            $msg = 'Image uploaded successfully';
            $result = [
                'url' => $url,
                'msg' =>  $msg
            ];

            // $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            // @header('Content-type: text/html; charset=utf-8');
            return $result;
            // $url = $request->upload->store('image');
            // $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            // $url = asset('storage/' . $url);
            // $msg = 'Image successfully uploaded';
            // $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            // @header('Content-type: text/html; charset=utf-8');
            // return $response;
        }
    }
}
