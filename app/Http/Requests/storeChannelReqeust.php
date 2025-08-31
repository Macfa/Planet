<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeChannelReqeust extends FormRequest
{

    // modify some rule & message for test

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:channels|max:10|min:3',
            'description' => 'required|max:255',            
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '토픽명을 입력해주세요.',
            'description.required' => '토픽 소개란을 입력해주세요.',
            'name.min' => '토픽명은 최소 3 글자 이상입니다.',
            'name.max' => '토픽명은 10 글자 이하입니다.',
            'description.max' => '토픽 소개란은 최대 255 글자 이하입니다.',
            'name.unique' => '토픽명이 이미 사용 중입니다.'        
        ];
    }
}
