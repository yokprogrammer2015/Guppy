<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|integer',
            'pic1' => 'required',
            'remark' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'กรุณากรอกหัวข้อสินค้า.',
            'price.required' => 'กรุณากรอกราคา.',
            'pic1.required' => 'กรุณาเลือกรูปภาพ.',
            'remark.required' => 'กรุณากรอกรายละเอียด.',
        ];
    }
}