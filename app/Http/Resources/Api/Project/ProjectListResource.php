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

        ];

        return $data;
    }
}
