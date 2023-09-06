<?php

namespace App\Http\Resources\Api\Property;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyObligationListForSelectList extends JsonResource
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
            'id' => $this->name,
            'name' => $this->name,

        ];

        return $data;
    }
}
