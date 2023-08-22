<?php

namespace App\Http\Resources\Api\CompanyBranch;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchListResource extends JsonResource
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
            'name' => $this->name ?? 'N/A',
            'mobile' => $this->mobile ?? 'N/A',
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,

        ];

        return $data;
    }
}
