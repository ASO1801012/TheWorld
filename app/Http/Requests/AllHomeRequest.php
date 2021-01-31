<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllHomeRequest extends FormRequest
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
        $varidate_rule = [
            'new_pass' => 'required|between:8,20',
            'confirmation_pass' => 'required|between:8,20',
            'one_pass' => 'required|digits:5|integer|numeric',
            'student_number' => 'required|digits:7|integer|numeric',
            'email' => 'required|email',
        ];
        return $varidate_rule;
    }

    public function messages()
    {
        $msg = [
            'required' => '必ず入力してください',
            'integer' => '整数で入力してください',
            'numeric' => '数字で入力してください',
            'between' => '８桁以上２０桁以内で入力してください',
            'one_pass.digits' => '５文字の数字を入力してください',
            'sutudent_number.digits' => '学籍番号７桁を入力してください',
            'email.email' => 'email形式で入力してください',
        ];
        return $msg;
    }
}
