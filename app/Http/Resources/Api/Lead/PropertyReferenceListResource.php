<?php

namespace App\Http\Resources\Api\Lead;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyReferenceListResource extends JsonResource
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
            'building_name' => $this->building_name ?? 'N/A',
            'price' => $this->price,
            'address' => $this->address ?? 'N/A',
            'locality' => $this->locality,
            'city' => $this->city,
            'owner_name' => $this->owner_name ?? 'N/A',
            'owner_phone' => $this->owner_phone ?? 'N/A',

        ];

        return $data;
    }
}
