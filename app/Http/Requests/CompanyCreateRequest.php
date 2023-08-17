<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CompanyCreateRequest extends FormRequest
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
            'company_name' => [
                'required',
                Rule::unique('companies', 'name')
                        ->where('owned_by', auth()->id())
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
        ];
    }

    public function attributes(){
        return [
        ];
    }
}
