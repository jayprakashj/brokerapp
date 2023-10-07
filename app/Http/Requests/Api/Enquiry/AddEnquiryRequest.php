<?php

namespace App\Http\Requests\Api\Enquiry;

use App\Models\Company;
use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddEnquiryRequest extends FormRequest
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
            'city' => [
                'required'
            ],
            'remark' => [
                'required'
            ],
            'email' => [
                'required',
                'email',
            ],
            'mobile' => [
                'required',
                'digits:10',
            ],
            'property_type.*' => [
                'required',
                Rule::exists('property_sub_type_lists', 'name')
                        ->where('company_id', (Company::first()->id ?? null) )
            ],
        ];
        if( $this->filled('enquiry_type') && in_array( $this->input('enquiry_type'), [ 'buy', 'rent_tenant'] )){
            $rules['interest_in'] = 'required';
        }
        return $rules;
    }

    public function attributes(){
        return [
            'property_type.*' => 'Property Type'
        ];
    }


    // public function withValidator($validator)
    // {
    //     $validator->after(function ($validator) {
    //         $failed = $validator->failed();
    //         $isMobileUnique = data_get( $failed, 'mobile.Unique');
    //         if( !empty( $isMobileUnique ) && is_array( $isMobileUnique )){
    //             $lead = Lead::whereCustomerMobile( $this->mobile )->first();
    //             $validator->errors()->add('__lead_exists', $lead->id);
    //         }
    //     });
    //     // throw (new ValidationException($validator))
    //     //             ->errorBag($this->errorBag)
    //     //             ->redirectTo($this->getRedirectUrl());
    // }
}
