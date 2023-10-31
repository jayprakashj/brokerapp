<?php

namespace App\Http\Requests\Api\Lead;

use App\Models\Lead;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AddLeadCommentRequest extends FormRequest
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
            'comment' => [
                'required'
            ],
            'followup_date' => [
                'nullable',
                'date',
                'after_or_equal:today'
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

}
