<?php

namespace App\Http\Resources\Api\Lead;

use App\Http\Resources\Api\CompanyBranch\BranchListForSelectList;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadEditResource extends JsonResource
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
            'mobile' => $this->customer_mobile,
            'email' => $this->customer_email,
            'city' => $this->customer_city,
            'remark' => $this->remark,
            'keywords' => $this->keywords,
            'purpose' => $this->purpose,
            'interest_in' => $this->interest_in,
            'lead_source' => $this->lead_source,
            'lead_status' => $this->lead_status,
            'budget' => $this->budget,
            'is_confidential' => $this->isConfidential(),
            'is_private' => $this->isPrivate(),
            'is_protected' => $this->isProtected(),
            'followup_date' => $this->followup_date,
            'assigned_date' => $this->assigned_date,
            'comments' => LeadCommentsResource::collection( $this->latestComments ),
        ];

        if( !is_null( $this->company_branch_id ) ){
            $data['company_branch_data'] = new BranchListForSelectList( $this->companyBranch );
        }
        if( !is_null( $this->assignToUser ) ){
            $data['assigned_to_data'] = $this->assignToUser->only(['id', 'name']);
        }
        if( !is_null( $this->property ) ){
            $data['property_data'] = $this->property->only(['id', 'name']);
        }
        return $data;
    }
}
