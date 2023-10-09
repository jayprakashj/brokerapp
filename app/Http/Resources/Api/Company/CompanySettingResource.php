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
        $data = [
            'enable_lead_notification' => $this->isLeadNotificationOn(),
            'enable_property_notification' => $this->isPropertyNotificationOn(),
            'lead_email' => $this->lead_email,
            'property_email' => $this->property_email,
        ];

        return $data;
    }
}
