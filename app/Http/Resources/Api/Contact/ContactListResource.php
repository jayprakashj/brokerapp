<?php

namespace App\Http\Resources\Api\Contact;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name ?? 'N/A',
            'company_name' => $this->company->name ?? 'N/A',
            'mobile' => $this->mobile ?? 'N/A',
            'email' => $this->email ?? 'N/A',
            'city' => $this->city ?? 'N/A',
            'gender' => Str::title($this->gender ?? 'N/A'),
            'is_male' => $this->isGenderMale(),
            'is_female' => $this->isGenderFemale(),
            'is_other_gender' => $this->isGenderOther(),
            'logo_url' => $this->logo_url,
            'contact_type' => $this->contactType->name ?? 'N/A',
            'customer_type' => $this->customerType->name ?? 'N/A',
            'updated_by' => $this->updatedUser->name ?? 'N/A',
            'updated_at_time' => $this->updated_at->format('d-m-Y h:i a'),

        ];

        return $data;
    }
}
