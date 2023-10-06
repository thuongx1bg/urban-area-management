<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'name' => 'required|max:255',
            'address' => 'required',
        ];

        return $rules;
    }

//    public function attributes()
//    {
//        return [
//            "name" => "Tên",
//            "description" => "Mô tả",
//            "exp" => "Kinh nghiệm",
//            "img" => "Ảnh",
//        ];
//    }
//
//    public function messages()
//    {
//        return [
//            "required" => ":attribute bắt buộc phải nhập",
//            "min" => ":attribute phải nhập tối đa",
//        ];
//    }
}
