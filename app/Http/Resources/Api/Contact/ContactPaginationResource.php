<?php

namespace App\Http\Resources\Api\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactPaginationResource extends JsonResource
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
            'current_page' => $this->currentPage(),
            'data' => ContactListResource::collection( $this->items() ),
            'per_page' => $this->perPage(),
            'total_records' => $this->total(),
            'first_item' => $this->firstItem(),
            'last_item' => $this->lastItem(),
        ];

        return $data;
    }
}
