<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AddTaskRequest extends FormRequest
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
            'description' => [
                'required'
            ],
            'status' => [
                'required',
                Rule::exists('task_statuses', 'name')
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
