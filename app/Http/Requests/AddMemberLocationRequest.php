<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMemberLocationRequest extends FormRequest
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
            'locations' => 'required|array',
            'locations.*.latitude' => 'required',
            'locations.*.longitude' => 'required',
            'locations.*.location_time' => 'required',
        ];
        return $rules;
    }

    public function attributes(){
        return [
            'locations.*.latitude' => 'Latitude',
            'locations.*.longitude' => 'Longitude',
            'locations.*.location_time' => 'Location Time',
        ];
    }
}
