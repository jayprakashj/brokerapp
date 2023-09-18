<?php

namespace App\Http\Requests\Api\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProjectRequest extends FormRequest
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
            'title' => [
                'required'
            ],
            'total_unit' => [
                'required'
            ],
            'city' => [
                'required'
            ],
            'locality' => [
                'required'
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
        ];
        return $rules;
    }

    public function attributes(){
        return [

        ];
    }
}
