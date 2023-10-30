<?php

namespace App\Http\Resources\Api\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanySettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $leadEmails = [
            $this->email
        ];
        $propertyEmails = [
            $this->email
        ];

        $leadEmails = array_filter( array_merge( $leadEmails, $this->leadEmailsArr() ) );
        $propertyEmails = array_filter( array_merge( $propertyEmails, $this->propertyEmailsArr() ) );

        $data = [
            'enable_lead_notification' => $this->isLeadNotificationOn(),
            'enable_property_notification' => $this->isPropertyNotificationOn(),
            'lead_email' => $this->lead_email,
            'property_email' => $this->property_email,
            'lead_emails' => $leadEmails,
            'property_emails' => $propertyEmails,
        ];

        return $data;
    }
}
