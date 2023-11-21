<?php

namespace App\Http\Resources\Api\Property;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyListResource extends JsonResource
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
            'company_branch' => $this->companyBranch->name ?? 'N/A',
            'city' => $this->city ?? 'N/A',
            'locality' => $this->locality ?? 'N/A',
            'property_type' => $this->property_type ?? 'N/A',
            'property_transaction' => $this->property_transaction ?? 'N/A',
            'is_verified' => $this->is_verified ?? false,
            'walk_through_link' => $this->walk_through_link,
            'assign_to' => $this->assignToUser->name ?? 'Unassigned',
            'updated_by' => $this->updatedUser->name ?? 'N/A',
            'updated_at_time' => $this->updated_at->format('d-m-Y h:i a'),

        ];

        return $data;
    }
}
