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
            'name' => $this->name,
            'gender' => $this->gender,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'city' => $this->city,
            'locality' => $this->locality,
            'pincode' => $this->pincode,
            'comment' => $this->comment,
            'logo' => $this->getLogoMediaId(),
            'logo_url' => $this->getLogoUrl(),
        ];

        if( !is_null( $this->customer_type_id ) ){
            $data['customer_type_data'] = $this->customerType->only(['id', 'name']);
        }
        if( !is_null( $this->contact_type_id ) ){
            $data['contact_type_data'] = $this->contactType->only(['id', 'name']);
        }
        return $data;
    }
}
