<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'กรุณากรอกชื่อ - นามสกุล ให้ถูกต้อง',
            'phone.required' => 'กรุณากรอกเบอร์โทร ให้ถูกต้อง',
            'email.required' => 'กรุณากรอกอีเมล์ ให้ถูกต้อง',
            'address.required' => 'กรุณากรอกที่อยู่จัดส่ง ให้ถูกต้อง',
        ];
    }
}