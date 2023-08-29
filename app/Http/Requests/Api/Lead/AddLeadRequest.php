<?php

namespace App\Http\Requests\Api\Lead;

use App\Models\Lead;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

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
        ];
        return $rules;
    }

    public function attributes(){
        return [

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
