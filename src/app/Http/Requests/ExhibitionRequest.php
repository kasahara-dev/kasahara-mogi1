<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ImgFileName;


class ExhibitionRequest extends FormRequest
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
            'itemName' => ['required'],
            'itemInfo' => ['required', 'max:255'],
            'userImgInput' => ['required', 'mimetypes:image/jpeg,image/png', new ImgFileName()],
            'category' => ['required'],
            'condition' => ['required'],
            'price' => ['required', 'integer', 'min:0', 'max:99999999'],
        ];
    }
    public function messages()
    {
        return [
            'itemName.required' => '商品名を入力してください',
            'itemInfo.required' => '商品説明を入力してください',
            'itemInfo.max' => '商品説明は255文字以内で入力してください',
            'userImgInput.required' => '商品画像を選択してください',
            'userImgInput.mimetypes' => '拡張子が.jpegもしくは.pngの画像を選択してください',
            'category.required' => '商品のカテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.integer' => '商品価格は0円以上99999999円以下の数値を入力してください',
            'price.min' => '商品価格は0円以上99999999円以下の数値を入力してください',
            'price.max' => '商品価格は0円以上99999999円以下の数値を入力してください'
        ];
    }
}
