<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
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
        $id = $this->route()->id;


        $uniqueRuleUserName = 'unique:users,username';
        $uniqueRuleCmt = 'unique:users,cmt';


        if($id){
            $checkOwn = User::find($id)->own_id == 0 ? true : false;
            if($checkOwn){
                $uniqueRuleEmail ='required|unique:users,email'.','.$id;
            }else{
                $uniqueRuleEmail = 'nullable';
            }
            $uniqueRuleUserName .= ','.$id;
            $uniqueRuleCmt .= ','.$id;

        }else{
            $checkOwn = Auth::user()->own_id == 0 ? true : false;
            if($checkOwn && Auth::user()->roles[0]->id != 2){
                $uniqueRuleEmail = 'required|unique:users,email';
            }else{
                $uniqueRuleEmail = 'nullable';
            }
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ' string | email | max:255 | '.$uniqueRuleEmail,
            'username' => 'required | string |max:255 | '.$uniqueRuleUserName,
            'password' => ['string', 'min:8', 'confirmed'],
            'cmt' => 'string | max:255 | nullable ',
            'phone' => 'string | max:255 | nullable',
            'status' => 'required',
            'date' => 'required|before:today|'

        ];
    }
}
