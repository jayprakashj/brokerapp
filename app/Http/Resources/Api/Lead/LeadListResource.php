<?php

namespace App\Http\Resources\Api\Lead;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadListResource extends JsonResource
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
            'title' => $this->title,
            'name' => $this->customer_name,
            'company_name' => $this->company->name ?? 'N/A',
            'property_name' => $this->properties->pluck('name') ?? 'N/A',
            'project_name' => $this->projects->pluck('title') ?? 'N/A',
            'mobile' => $this->customer_mobile ?? 'N/A',
            'email' => $this->customer_email ?? 'N/A',
            'city' => $this->customer_city ?? 'N/A',
            'branch' => $this->companyBranch->name ?? 'N/A',
            'followup_date' => $this->followup_date ?? 'N/A',
            'status' => $this->lead_status ?? 'N/A',
            'lead_source' => $this->lead_source ?? 'N/A',
            'assigned_to' => $this->assignToUser->name ?? 'N/A',
            'updated_by' => $this->updatedUser->name ?? 'N/A',
            'updated_at_time' => $this->updated_at->format('d-m-Y h:i a'),

        ];

        return $data;
    }
}
