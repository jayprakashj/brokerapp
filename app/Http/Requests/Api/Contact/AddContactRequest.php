<?php

namespace App\Http\Requests\Api\Contact;

use App\Models\Contact;
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
            'name_prefix' => [
                'required',
                'in:' . implode(',',array_keys( Contact::NAME_PREFIX_LIST ))
            ],
            'country_code' => [
                'required',
                'integer'
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
            'other_contact_no' => [
                'nullable',
                'digits:10',
            ],
            'other_contact_country_code' => [
                'nullable',
                'required_with:other_contact_no',
                'integer'
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
            'birth_date' => [
                'nullable',
                'date',
                'before:today'
            ],
            'website' => [
                'nullable',
                'url'
            ]
            // 'state' => 'required',
            // 'city' => 'required',
            // 'address' => 'required',
        ];

        if( $this->filled('occupation') ){
            $rules['occupation'] = 'in:' . implode(',',array_keys( Contact::OCCUPATION_LIST ));
        }
        return $rules;
    }

    public function attributes(){
        return [

        ];
    }
}
