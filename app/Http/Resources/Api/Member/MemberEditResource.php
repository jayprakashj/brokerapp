<?php

namespace App\Http\Resources\Api\Member;

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
            'email' => $this->email,
            'role' => $this->role_id,
            'is_accepted' => $this->isAccepted(),
        ];

        return $data;
    }
}
