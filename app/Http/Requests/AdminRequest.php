<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
            'number' =>'filled|unique:admins,adminsId,'. $this->input('id').',id,adminsId,' . $this->input('number'),
            'name' => 'required|between:0,20',
            'school' => 'required',
            'email' => 'filled|email|unique:admins,email,'. $this->input('id').',id,email,' . $this->input('email'),
            'pass' => 'filled|min:8',
        ];

        return $vardate_rule;
    }

    public function messages()
    {
        $msg = [
            'number.unique'=>'この番号は既に使用されています',
            'email.unique'=>'このメールアドレスは既に使用されています',
            'required' => '必ず入力してください',
            'name.between' => '20文字以内で入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'min'=>'8桁以上で入力してください',
            'filled' => '必ず入力してください',
        ];

        return $msg;
    }
}
