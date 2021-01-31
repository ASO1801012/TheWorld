<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonCreateRequest extends FormRequest
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
            'language_id' =>'required',
            'intro' => 'required|between:0,250',
            'dualData' => 'required',
        ];

        return $vardate_rule;
    }

    public function messages()
    {
        $msg = [
            'language_id.required' => '必ず選択してください',
            'dualData.required' => '必ず選択してください',
            'intro.required' => '必ず入力してください',
            'between' => '250文字以内で入力してください',
        ];

        return $msg;
    }
}
