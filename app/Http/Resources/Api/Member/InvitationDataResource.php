<?php

namespace App\Http\Resources\Api\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationDataResource extends JsonResource
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
            'company_name' => $this->company->name,
            'company_email' => $this->company->owner->email,
            'company_phone' => $this->company->owner->mobile,
            'creator' => $this->createdUser->name ?? '',
            'is_pending' => $this->isPending(),
        ];

        return $data;
    }
}
