<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ImgFileName;

class CreateMessageRequest extends FormRequest
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
        return[
            'message_img_input' => ['nullable','mimetypes:image/jpeg,image/png', new ImgFileName()],
            'new_message_text' => ['required', 'max:400'],
        ];
    }
    public function messages()
    {
        return [
            'message_img_input.mimetypes' => '「.png」または「.jpg」形式でアップロードしてください',
            'new_message_text.required' => '本文を入力してください',
            'new_message_text.max' => '本文は400文字以内で入力してください',
        ];
    }

}
