<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ImgFileName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $name = $value->getClientOriginalName();
        return (Str::is('*.png', $name) or Str::is('*.jpeg', $name));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '拡張子が.jpegもしくは.pngの画像を選択してください';
    }
}
