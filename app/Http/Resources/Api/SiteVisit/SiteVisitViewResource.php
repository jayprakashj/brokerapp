<?php

namespace App\Http\Resources\Api\SiteVisit;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteVisitViewResource extends JsonResource
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
            'type' => $this->type,
            'property' => $this->property->name ?? null,
            'project' => $this->project->title ?? null,
            'comments' => $this->comments ?? 'N/A',
            'assign_user' => 'N/A',
            'time_in' => $this->time_in ?? 'N/A',
            'time_out' => $this->time_out ?? 'N/A',
            'location' => $this->location ?? 'N/A',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'company_branch' => $this->companyBranch->name ?? 'N/A',
            'source_manager_name' => $this->sourceManagerUser->name ?? 'N/A',
            'closing_manager_name' => $this->closingManagerUser->name ?? 'N/A',
            'created_user_name' => $this->createdUser->name  ?? 'N/A',
            'updated_user_name' => $this->updatedUser->name ?? 'N/A',
            'created_at_time' => $this->created_at->format('d-m-Y h:i a'),
            'updated_at_time' => $this->created_at->format('d-m-Y h:i a'),
            'leads' => LeadListResource::collection( $this->leads )
        ];

        if( !is_null( $this->assignToUser ) ){
            $data['assign_user'] = $this->assignToUser->name;
        }
        if( !is_null( $this->project ) ){

            $data['project_data'] = $this->project->only(['id','title','rera_reg_no','project_no','address','city','locality','landmark','building']);
        }
        if( !is_null( $this->property ) ){
            $data['property_data'] = $this->property->only(['id','name','building_name','unit_no','property_type','address','city','locality']);
        }
        return $data;
    }
}
