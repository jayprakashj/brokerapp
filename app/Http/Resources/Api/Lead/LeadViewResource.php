<?php

namespace App\Http\Resources\Api\Lead;

use App\Http\Resources\Api\CompanyBranch\BranchListForSelectList;
use App\Models\Contact;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadViewResource extends JsonResource
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
            'enquiry_type' => $this->enquiry_type ?? '-',
            'name' => $this->getNameWithPrefix (),
            'mobile' => $this->getMobileWithCountryCode(),
            'email' => $this->customer_email  ?? 'N/A',
            'city' => $this->customer_city  ?? 'N/A',
            'remark' => $this->remark  ?? 'N/A',
            'keywords' => $this->keywords,
            'purpose' => $this->purpose ?? 'N/A',
            'interest_in' => $this->interest_in ?? 'N/A',
            'lead_source' => $this->lead_source,
            'lead_status' => $this->lead_status,
            'min_budget' => \Helper::formatAmount($this->min_budget ?? '0.00'),
            'max_budget' => \Helper::formatAmount($this->max_budget ?? '0.00'),
            'is_confidential' => $this->isConfidential(),
            'is_private' => $this->isPrivate(),
            'is_protected' => $this->isProtected(),
            'followup_date' => $this->followup_date ?? 'N/A',
            'assigned_date' => $this->assigned_date ?? 'N/A',
            'company_branch' => $this->companyBranch->name  ?? 'N/A',
            'assigned_user' => $this->assignToUser->name ?? 'N/A',
            'created_user_name' => $this->createdUser->name  ?? 'N/A',
            'updated_user_name' => $this->updatedUser->name ?? 'N/A',
            'created_at_time' => $this->created_at->format('d-m-Y h:i a'),
            'updated_at_time' => $this->created_at->format('d-m-Y h:i a'),
            'comments' => LeadCommentsResource::collection( $this->latestComments ),
            'property_type' => $this->property_type ? implode(', ', $this->property_type ) : 'N/A',
            'property_references' => PropertyReferenceListResource::collection( $this->getPropertySuggestions() ),
            'contact_type' => null,
            'customer_type' => null,
            'gender' => null,
        ];

        if( $this->properties->count() ){
            $data['property_names'] = $this->properties->pluck('name');
        }
        if( $this->projects->count() ){
            $data['project_names'] = $this->projects->pluck('title');
        }
        if( !is_null( $this->contact ) ){
            $contact = $this->contact;
            $data['gender'] = $contact->gender;

            if( !is_null( $contact->customerType ) ){
                $data['customer_type'] = $contact->customerType->name;
            }
            if( !is_null( $contact->contactType ) ){
                $data['contact_type'] = $contact->contactType->name;
            }
        }
        return $data;
    }
}
