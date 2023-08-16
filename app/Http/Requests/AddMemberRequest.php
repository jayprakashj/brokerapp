<?php

namespace App\Http\Requests;

use App\Models\CompanyMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AddMemberRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('company_members', 'email')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'role' => 'required',
        ];
        if( $this->id ){
            $member = CompanyMember::find( $this->id );
            if( $member->isAccepted() ){
                unset( $rules['email']);
            }
        }
        return $rules;
    }

    public function attributes(){
        return [
            'role_name' => 'Role Name',
        ];
    }
}
