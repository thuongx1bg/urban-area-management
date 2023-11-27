<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QrCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'note' => 'required| string ',
            'name' => 'required|string | max:255 ',
            'phone' => 'required | string | max:255 |',
            'date' => 'required| after:now',
            'gender' => ['required ',Rule::in([0,1])]
        ];

        return $rules;
    }
}
