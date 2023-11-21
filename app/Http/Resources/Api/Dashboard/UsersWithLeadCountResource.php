<?php

namespace App\Http\Resources\Api\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersWithLeadCountResource extends JsonResource
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
            'qualified' => $this->qualified ?? 0,
            'oppertunities' => $this->oppertunities ?? 0,
            'visited' => $this->visited ?? 0,
            'won' => $this->won_leads ?? 0,

        ];

        return $data;
    }
}
