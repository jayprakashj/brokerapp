<?php

namespace App\Http\Resources\Api\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultCompanyResource extends JsonResource
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
            'company_name' => $this->name,
            'pan_no' => $this->pan_no,
            'gst_no' => $this->gst_no,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'logo' => $this->getLogoMediaId(),
            'logo_url' => $this->getLogoUrl(),
            'is_default' => $this->isDefault(),
            'status' => $this->isActive(),
        ];

        return $data;
    }
}
