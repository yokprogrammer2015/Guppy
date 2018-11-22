<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'amount' => 'required|integer|min:2',
            'payDate' => 'required',
            'payTime' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'กรุณาระบุจำนวนเงิน ให้ถูกต้อง',
            'payDate.required' => 'กรุณาระบุวันที่โอน ให้ถูกต้อง',
            'payTime.required' => 'กรุณาระบุเวลาที่โอน ให้ถูกต้อง'
        ];
    }
}
