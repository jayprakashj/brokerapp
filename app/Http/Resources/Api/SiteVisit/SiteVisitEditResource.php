<?php

namespace App\Http\Resources\Api\SiteVisit;

use App\Http\Resources\Api\CompanyBranch\BranchListForSelectList;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteVisitEditResource extends JsonResource
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
            'comments' => $this->comments,
            'assign_to' => $this->assign_to,
            'type' => $this->type,
            'visit_type' => $this->visit_type,
            'source_manager' => $this->source_manager,
            'closing_manager' => $this->closing_manager,
            'location' => $this->location,
            'latitude' => (float)$this->latitude,
            'longitude' => (float)$this->longitude,
            'time_in' => $this->time_in ? Carbon::parse( $this->time_in )->format('Y-m-d\TH:i') : null,
            'time_out' => $this->time_out? Carbon::parse( $this->time_out )->format('Y-m-d\TH:i') : null,
            'property_id' => $this->property_id,
            'project_id' => $this->project_id,
        ];
        if( !is_null( $this->company_branch_id ) ){
            $data['company_branch_data'] = new BranchListForSelectList( $this->companyBranch );
        }
        if( !is_null( $this->assignToUser ) ){
            $data['assign_user_data'] = $this->assignToUser->only(['id', 'name']);
        }
        if( !is_null( $this->property ) ){
            $data['property_data'] = $this->property->only(['id', 'name']);
        }
        if( !is_null( $this->project ) ){
            $data['project_data'] = $this->project->only(['id', 'title']);
        }

        if( $this->leads->count() ){
            $data['leads'] = $this->leads->pluck('id');
        }
        return $data;
    }
}
