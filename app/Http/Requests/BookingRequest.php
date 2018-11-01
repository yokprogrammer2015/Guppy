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
            'cat_id' => 'required',
            'dep_id' => 'required',
            'time_id' => 'required',
            'arr_id' => 'required',
            'travel_date' => 'required|date|date_format:m/d/Y',
            'adult' => 'required|integer|min:1',
            'voucher_no' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'dep_id.required' => 'The Departure field is required.',
            'time_id.required' => 'The Time field is required.',
            'arr_id.required' => 'The Arrive field is required.',
            'travel_date.required' => 'The Date field is required.',
            'adult.required' => 'The Passenger / Adult field is required.',
            'voucher_no.required' => 'The Voucher field is required.',
            'name.required' => 'The Name field is required.',
            'email.required' => 'The Email field is required.',
        ];
    }
}
