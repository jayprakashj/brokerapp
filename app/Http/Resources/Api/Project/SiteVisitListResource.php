<?php

namespace App\Http\Resources\Api\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteVisitListResource extends JsonResource
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
            'site_name' => $this->site_name,
            'site_owner' => $this->site_owner,
            'assign_user' => $this->assignToUser->name ?? 'N/A',
            'time_in' => $this->time_in ?? 'N/A',
            'time_out' => $this->time_out ?? 'N/A',
            'location' => $this->location ?? 'N/A',
            'visit_type' => $this->visit_type ?? 'N/A',
            'company_branch' => $this->companyBranch->name ?? 'N/A',
            'source_manager_name' => $this->sourceManagerUser->name ?? 'N/A',
            'closing_manager_name' => $this->closingManagerUser->name ?? 'N/A',
            'created_user_name' => $this->createdUser->name  ?? 'N/A',
            'updated_user_name' => $this->updatedUser->name ?? 'N/A',
            'created_at_time' => $this->created_at->format('d-m-Y h:i a'),
            'updated_at_time' => $this->created_at->format('d-m-Y h:i a'),
        ];


        return $data;
    }
}
