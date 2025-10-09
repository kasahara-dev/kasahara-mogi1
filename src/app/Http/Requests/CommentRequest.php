<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
        if (isset($_POST['send-comment'])) {
            // コメント送信時バリデーション
            return [
                'commentInput' => ['required', 'max:255'],
            ];
        } else {
            // コメント送信時以外はバリデーションなし
            return [];
        }
    }
    public function messages()
    {
        return [
            'commentInput.required' => 'コメントを入力してください',
            'commentInput.max' => 'コメントは255文字以内で入力してください',
        ];
    }
}
