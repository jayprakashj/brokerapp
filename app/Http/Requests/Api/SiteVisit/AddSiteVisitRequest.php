<?php

namespace App\Http\Requests\Api\SiteVisit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddSiteVisitRequest extends FormRequest
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
            'site_name' => [
                'required'
            ],
            'site_owner' => [
                'required'
            ],
            'location' => [
                'required'
            ],
            'type' => [
                'required',
                'in:property,project'
            ],
            'time_in' => [
                'nullable',
                'date_format:Y-m-d\TH:i'
            ],
            'time_out' => [
                'nullable',
                'date_format:Y-m-d\TH:i'
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
            ],
            'leads.*' => [
                'nullable',
                Rule::exists('leads', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'company_branch' => [
                'required',
                Rule::exists('company_branches', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'assign_to' => [
                'nullable',
                Rule::exists('company_members', 'user_id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'source_manager' => [
                'nullable',
                Rule::exists('company_members', 'user_id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'opening_manager' => [
                'nullable',
                Rule::exists('company_members', 'user_id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
        ];
        return $rules;
    }

    public function attributes(){
        return [
            'project_id' => 'Project',
            'property_id' => 'Property',
        ];
    }
}
