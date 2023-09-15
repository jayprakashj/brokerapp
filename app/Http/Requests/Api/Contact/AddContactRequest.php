<?php

namespace App\Http\Requests\Api\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AddContactRequest extends FormRequest
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

        $rules =  [
            //
            'name' => [
                'required'
            ],
            'gender' => [
                'required',
                'in:male,female,other'
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('contacts', 'email')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('contacts', 'mobile')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'contact_type' => 'required',
            'customer_type' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'address' => 'required',
        ];
        return $rules;
    }

    public function attributes(){
        return [

        ];
    }
}
