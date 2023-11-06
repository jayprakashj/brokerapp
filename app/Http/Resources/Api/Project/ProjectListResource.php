<?php

namespace App\Http\Resources\Api\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectListResource extends JsonResource
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
            'company_name' => $this->company->name ?? 'N/A',
            'company_branch' => $this->companyBranch->name ?? 'N/A',
            'title' => $this->title ?? 'N/A',
            'project_no' => $this->project_no ?? 'N/A',
            'locality' => $this->locality ?? 'N/A',
            'city' => $this->city ?? 'N/A',
            'walk_through_link' => $this->walkthrough_link,
            'virtual_tour' => $this->virtual_tour,
            'assigned_to' => $this->assignToUser->name ?? 'N/A',
            'updated_by' => $this->updatedUser->name ?? 'N/A',
            'updated_at_time' => $this->updated_at->format('d-m-Y h:i a'),

        ];

        return $data;
    }
}
