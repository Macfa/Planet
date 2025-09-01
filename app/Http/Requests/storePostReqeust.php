<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storePostReqeust extends FormRequest
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
            'channel_id' => 'required',
            'title' => 'required|max:15|min:2',
            'content' => 'required',            
        ];
    }
    public function messages()
    {
        return [
            'channel_id.required' => '채널을 선택해주세요.',
            'title.required' => '게시글명을 입력해주세요.',
            'title.min' => '게시글명은 최소 2 글자 이상입니다.',
            'title.max' => '게시글명은 15 글자 이하입니다.',
            'content.required' => '내용을 입력해주세요.',
        ];
    }
}
