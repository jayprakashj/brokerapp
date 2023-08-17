<?php

namespace App\Http\Resources\Api\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyListResource extends JsonResource
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
            'name' => $this->name,
            'is_owned' => $this->isOwnedByMe(),
            'creator' => $this->getOwnerName(),
            'is_default' => $this->isDefault(),
            'is_active' => $this->isActive(),
        ];

        return $data;
    }
}
