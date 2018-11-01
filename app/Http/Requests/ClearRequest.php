<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClearRequest extends FormRequest
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
            'order_id' => 'required',
            'bank_id' => 'required',
            'branch_id' => 'required',
            'ref_no' => 'required',
            'clear_date' => 'required|date|date_format:m/d/Y',
            'amount' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'The Order field is checked.',
            'bank_id.required' => 'The Bank field is required.',
            'branch_id.required' => 'The Bank field is required.',
            'ref_no.required' => 'The Ref No field is required.',
            'clear_date.required' => 'The Date field is required.',
            'amount.required' => 'The Amount field is required.',
        ];
    }
}
