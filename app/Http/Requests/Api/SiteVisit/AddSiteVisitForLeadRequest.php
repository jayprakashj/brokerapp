<?php

namespace App\Http\Requests\Api\SiteVisit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddSiteVisitForLeadRequest extends FormRequest
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

            // 'latitude' => [
            //     'required',
            // ],
            // 'longitude' => [
            //     'required',
            // ],
            'visit_type' => [
                'required',
            ],
            'lead_id' => [
                'required',
                Rule::exists('leads', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'property_id' => [
                'required_if:type,property',
                'nullable',
                Rule::exists('properties', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'project_id' => [
                'required_if:type,project',
                'nullable',
                Rule::exists('projects', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ]
        ];
        return $rules;
    }

    public function attributes(){
        return [
            'project_id' => 'Project',
            'property_id' => 'Property',
        ];
    }

    public function messages(){
        return [
            'latitude.required' => 'Current location positions is required',
            'longitude.required' => 'Current location positions is required',
        ];
    }
}
