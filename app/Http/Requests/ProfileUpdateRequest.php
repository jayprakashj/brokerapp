<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email,'.auth()->id() . ',id',
            'mobile' => 'required|digits:10|unique:users,mobile,'.auth()->id() . ',id',
        ];
    }

    public function attributes(){
        return [
        ];
    }
}
