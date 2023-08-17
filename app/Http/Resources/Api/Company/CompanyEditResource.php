<?php

namespace App\Http\Resources\Api\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyEditResource extends JsonResource
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
            'company_name' => $this->name,
            'status' => $this->isActive(),
        ];

        return $data;
    }
}
