<?php

namespace App\Http\Resources\Api\Member;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberListResource extends JsonResource
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
            'member_name' => $this->memberUser->name ?? 'N/A',
            'member_phone' => $this->memberUser->mobile ?? 'N/A',
            'email' => $this->email,
            'secondary_mobile' => $this->memberUser->secondary_mobile,
            'secondary_email' => $this->memberUser->secondary_email,
            'logo_url' => $this->memberUser ? $this->memberUser->getLogoUrl() : (User::getDefaultLogoUrl()),
            'creator' => $this->createdUser->name,
            'is_owned' => $this->isOwnerMe(),
            'is_company_owner' => $this->isOwner(),
            'is_self' => $this->isMe(),
            'role_name' => $this->role->name ?? '',
            'is_accepted' => $this->isAccepted(),
            'company_branch' => $this->companyBranch->name ?? 'N/A',

        ];

        return $data;
    }
}
