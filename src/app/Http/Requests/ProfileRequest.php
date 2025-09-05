<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
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
            'userImgInput' => ['mimes:jpeg,png'],
            'name' => ['required', 'max:20'],
            'postNumber' => ['required', 'size:8', 'regex:/^[0-9-]+$/'],
            'address' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'userImgInput.mimes' => '拡張子が.jpegもしくは.pngの画像を選択してください',
            'name.required' => '名前を入力してください',
            'name.max' => '名前は20文字以内で入力してください',
            'postNumber.required' => '郵便番号を入力してください',
            'postNumber.size' => '郵便番号はハイフンを含む8文字で入力してください',
            'postNumber.regex' => '郵便番号はハイフンを含む8文字で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}