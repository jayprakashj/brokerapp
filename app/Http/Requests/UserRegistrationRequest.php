<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegistrationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'company_name' => 'required_if:type,company|max:190',
            'name' => 'required|max:190',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|digits:10|unique:users,mobile',
            'password' => [
                'required',
                Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ],
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function attributes(){
        return [
            'company_name' => 'Company Name',
            'name' => 'Name',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ];
    }
}
