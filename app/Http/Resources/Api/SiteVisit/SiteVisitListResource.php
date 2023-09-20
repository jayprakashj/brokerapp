<?php

namespace App\Http\Resources\Api\SiteVisit;

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
            'site_name' => $this->site_name ?? 'N/A',
            'company_name' => $this->company->name ?? 'N/A',
            'company_branch' => $this->companyBranch->name ?? 'N/A',
            'property' => (!is_null( $this->property ) ? $this->property->name : 'N/A'),
            'project' => (!is_null( $this->project ) ? $this->project->title : 'N/A'),
            'assign_user' => $this->assignToUser->name ?? 'N/A',
            'visit_type' => $this->visit_type ?? 'N/A',
            'time_in' => $this->time_in ?? 'N/A',
            'time_out' => $this->time_out ?? 'N/A',

        ];

        return $data;
    }
}
