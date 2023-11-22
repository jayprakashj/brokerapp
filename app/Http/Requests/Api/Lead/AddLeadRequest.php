<?php

namespace App\Http\Requests\Api\Lead;

use App\Models\Contact;
use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddLeadRequest extends FormRequest
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

            //
            'title' => [
                'required'
            ],
            'name' => [
                'required'
            ],
            'name_prefix' => [
                'required',
                'in:' . implode(',',array_keys( Contact::NAME_PREFIX_LIST ))
            ],
            'gender' => [
                'required',
                'in:male,female,other'
            ],
            'city' => [
                'required'
            ],
            'keywords' => [
                'required'
            ],
            'interest_in' => [
                'required'
            ],
            'purpose' => [
                'required'
            ],
            'enquiry_type' => [
                'required',
                Rule::in( array_values( Lead::ENQUIRY_TYPES ) )
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('leads', 'customer_email')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('leads', 'customer_mobile')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'company_branch' => [
                'required',
                Rule::exists('company_branches', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'lead_source' => [
                'required',
                Rule::exists('lead_sources', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'lead_status' => [
                'required',
                Rule::exists('lead_statuses', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'property.*' => [
                'nullable',
                Rule::exists('properties', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'project.*' => [
                'nullable',
                Rule::exists('projects', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'min_budget' => [
                'required',
                'integer',
                'min:1',
                'lt:max_budget',
            ],
            'max_budget' => [
                'required',
                'integer',
                'gt:min_budget'
            ],
            'country_code' => [
                'required',
                'integer'
            ],
            'contact_type' => 'required',
            'customer_type' => 'required',
        ];
        return $rules;
    }

    public function attributes(){
        return [
            'property.*' => 'Property',
            'project.*' => 'Project',
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $failed = $validator->failed();
            $isMobileUnique = data_get( $failed, 'mobile.Unique');
            if( !empty( $isMobileUnique ) && is_array( $isMobileUnique )){
                $lead = Lead::whereCustomerMobile( $this->mobile )->first();
                $validator->errors()->add('__lead_exists', $lead->id);
            }
        });
        // throw (new ValidationException($validator))
        //             ->errorBag($this->errorBag)
        //             ->redirectTo($this->getRedirectUrl());
    }
}
