<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'post_number' => ['required', 'size:8', 'regex:/^[0-9-]+$/'],
            'address' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'post_number.required' => '郵便番号を入力してください',
            'post_number.size' => '郵便番号はハイフンを含む8文字で入力してください',
            'post_number.regex' => '郵便番号はハイフンを含む8文字で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
