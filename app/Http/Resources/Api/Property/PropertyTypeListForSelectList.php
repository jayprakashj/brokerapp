<?php

namespace App\Http\Resources\Api\Property;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyTypeListForSelectList extends JsonResource
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
            'value' => $this->id,
            'label' => $this->name,

        ];

        return $data;
    }
}
