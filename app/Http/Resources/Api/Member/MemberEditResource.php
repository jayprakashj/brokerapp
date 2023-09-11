<?php

namespace App\Http\Resources\Api\Member;

use App\Http\Resources\Api\CompanyBranch\BranchListForSelectList;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberEditResource extends JsonResource
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
            'name' => $this->memberUser->name,
            'email' => $this->email,
            'mobile' => $this->memberUser->mobile,
            'address' => $this->memberUser->address,
            'role' => $this->role_id,
            'logo' => $this->memberUser->getLogoMediaId(),
            'logo_url' => $this->memberUser->getLogoUrl(),
        ];
        if( !is_null( $this->company_branch_id ) ){
            $data['company_branch_data'] = new BranchListForSelectList( $this->companyBranch );
        }
        if( !is_null( $this->role ) ){
            $data['role_data'] = $this->role->only(['id', 'name']);
        }
        return $data;
    }
}
