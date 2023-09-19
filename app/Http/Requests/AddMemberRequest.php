<?php

namespace App\Http\Requests;

use App\Models\Company;
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

        $userId = null;
        if( $this->id ){
            $member = CompanyMember::with('memberUser')->find( $this->id );
            $userId = $member->user_id;
        }
        $rules =  [
            //
            'name' => 'required',
            'role' => 'required',
            'company_branch' => 'required',
            'mobile' => [
                'required',
                'digits:10',
                Rule::unique('users', 'mobile')
                        // ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $userId, function( $clause ) use ($userId) {
                            $clause->whereNot('id', $userId);
                        })
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                        // ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $userId, function( $clause ) use ($userId) {
                            $clause->whereNot('id', $userId);
                        })
            ],
            'secondary_mobile' => [
                'nullable',
                'digits:10',
                Rule::unique('users', 'secondary_mobile')
                        // ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $userId, function( $clause ) use ($userId) {
                            $clause->whereNot('id', $userId);
                        })
            ],
            'secondary_email' => [
                'nullable',
                'email',
                Rule::unique('users', 'secondary_email')
                        // ->where('company_id', \Helper::retrieveDefaultCompany()->id )
                        ->when( $userId, function( $clause ) use ($userId) {
                            $clause->whereNot('id', $userId);
                        })
            ],
            'company_branch' => [
                'required',
                Rule::exists('company_branches', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'role' => [
                'required',
                Rule::exists('roles', 'id')
                        ->where('company_id', \Helper::retrieveDefaultCompany()->id )
            ],
            'password' => [
                'required',
                Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ],
            'confirm_password' => 'required|same:password'
        ];
        if( $this->id ){
            $rules['password'] = [
                    'nullable',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
            ];
            $rules['confirm_password'] = 'nullable|same:password';
        }
        return $rules;
    }

    public function attributes(){
        return [
            'role_name' => 'Role Name',
        ];
    }
}
