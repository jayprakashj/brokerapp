<?php

namespace App\Http\Requests\Api\CompanyBranch;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AddBranchRequest extends FormRequest
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
                'required',
                Rule::unique('company_branches', 'name')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('company_branches', 'email')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('company_branches', 'mobile')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
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
