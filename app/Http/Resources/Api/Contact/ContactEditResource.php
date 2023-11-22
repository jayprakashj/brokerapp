<?php

namespace App\Http\Resources\Api\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactEditResource extends JsonResource
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
            'name_prefix' => $this->name_prefix,
            'name' => $this->name,
            'gender' => $this->gender,
            'email' => $this->email,
            'is_email_verified' => ($this->is_email_verified == 1),
            'country_code' => $this->country_code,
            'mobile' => $this->mobile,
            'is_whatsapp_available' => ($this->is_whatsapp_available == 1),
            'other_contact_country_code' => $this->other_contact_country_code,
            'other_contact_no' => $this->other_contact_no,
            'address' => $this->address,
            'city' => $this->city,
            'locality' => $this->locality,
            'pincode' => $this->pincode,
            'company_name' => $this->company_name,
            'occupation' => $this->occupation,
            'designation' => $this->designation,
            'birth_date' => $this->birth_date,
            'website' => $this->website,
            'enable_whatsapp_wishes' => ($this->enable_whatsapp_wishes == 1),
            'enable_sms_wishes' => ($this->enable_sms_wishes == 1),
            'enable_email_wishes' => ($this->enable_email_wishes == 1),
            'comment' => $this->comment,
            'logo' => $this->getLogoMediaId(),
            'logo_url' => $this->getLogoUrl(),
        ];

        if( !is_null( $this->customerType ) ){
            $data['customer_type_data'] = $this->customerType->only(['id', 'name']);
        }
        if( !is_null( $this->contactType ) ){
            $data['contact_type_data'] = $this->contactType->only(['id', 'name']);
        }
        return $data;
    }
}
