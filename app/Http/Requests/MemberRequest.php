<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6',
            'name' => 'required',
            'branch_id' => 'required',
            'type_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'branch_id.required' => 'The branch field is required.',
            'type_id.required' => 'The type field is required.',
        ];
    }
}
