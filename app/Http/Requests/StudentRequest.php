<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
            'student_number' =>'required|size:7|unique:users,student_number,'. $this->input('id').',id,student_number,' . $this->input('student_number'),
            'name' => 'required|between:0,20',
            'email' => 'required|email|unique:users,email,'. $this->input('id').',id,email,' . $this->input('email'),
            'school' => 'required',
            'pass' => 'filled|min:8',
        ];

        return $vardate_rule;
    }

    public function messages()
    {
        $msg = [
            'student_number.unique'=>'この番号は既に使用されています',
            'email.unique'=>'このメールアドレスは既に使用されています',
            'required' => '必ず入力してください',
            'size' => '７桁で入力してください',
            'name.between' => '20文字以内で入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'min'=>'8桁以上で入力してください',
            'filled' => '必ず入力してください',
        ];

        return $msg;
    }
}
