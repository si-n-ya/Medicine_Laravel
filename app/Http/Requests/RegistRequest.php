<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistRequest extends FormRequest
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
            //
            'name' => 'required',
            'week' => 'required',
            'time' => 'required',
            'get_date' => 'date',
            'use_num' => 'numeric',
            'stock_num' => 'numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'week.required' => '服用する曜日を選択してください',
            'time.required' => '服用する時刻を選択してください',
            'get_date.date' => 'YYYY-mm-dd の形式で入力してください',
            'use_num.numeric' => '半角数字で一回に服用する量を入力してください',
            'stock_num.numeric' => '半角数字で在庫数を入力してください'
        ];
    }
}