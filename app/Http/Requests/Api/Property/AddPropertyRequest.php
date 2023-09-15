<?php

namespace App\Http\Requests\Api\Property;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AddPropertyRequest extends FormRequest
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
            'address' => [
                'required'
            ],
            'city' => [
                'required'
            ],
            'locality' => [
                'required'
            ],
            'price' => [
                'required',
                'numeric'
            ],

            'company_branch' => [
                'required',
                Rule::exists('company_branches', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'property_type' => [
                'required',
                Rule::exists('property_type_lists', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'property_transaction' => [
                'required',
                Rule::exists('property_transaction_lists', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'property_furnishing' => [
                'nullable',
                Rule::exists('property_furnish_lists', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'property_facing' => [
                'nullable',
                Rule::exists('property_facing_lists', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'property_obligation' => [
                'nullable',
                Rule::exists('property_obligation_lists', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'assign_to' => [
                'nullable',
                Rule::exists('company_members', 'user_id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
        ];
        return $rules;
    }

    public function attributes(){
        return [

        ];
    }
}
