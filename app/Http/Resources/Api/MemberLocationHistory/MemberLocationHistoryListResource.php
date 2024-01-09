<?php

namespace App\Http\Resources\Api\MemberLocationHistory;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberLocationHistoryListResource extends JsonResource
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
            'latitude' => (float)$this->latitude,
            'longitude' => (float)$this->longitude,
            'location_time' => $this->location_time->format('d M, Y h:i a'),
            'address' => $this->address,
            'formatted_address' => $this->formatted_address,
            'locality' => $this->locality,
            'city' => $this->city,
            'country' => $this->country,

        ];

        return $data;
    }
}
