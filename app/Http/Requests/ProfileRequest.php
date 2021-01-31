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
        $vardate_rule = [
            'name' =>'required|between:0,20',
            'intro' => 'between:0,100',
        ];

        return $vardate_rule;
    }

    public function messages()
    {
        $msg = [
            'required' => '必ず入力してください',
            'name.between' => '20文字以内で入力してください',
            'intro.between' => '100文字以内で入力してください',
        ];

        return $msg;
    }
}
