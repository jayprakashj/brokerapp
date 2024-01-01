<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RoleCreateRequest extends FormRequest
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
        return [
            //
            'role_name' => [
                'required',
                Rule::unique('roles', 'name')
                        ->where('user_id', auth()->id())
                        ->when( $this->id, function( $clause ){
                            $clause->whereNot('id', $this->id);
                        })
            ],
            'hierarchy_order' => [
                'required',
                'integer',
                'min:1'
            ]
        ];
    }

    public function attributes(){
        return [
            'role_name' => 'Role Name',
        ];
    }
}
