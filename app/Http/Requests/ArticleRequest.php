<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'topic' => 'required',
            'detail' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'topic.required' => 'กรุณากรอกหัวข้อ ให้ถูกต้อง',
            'detail.required' => 'กรุณากรอกรายละเอียด ให้ถูกต้อง',
        ];
    }
}
