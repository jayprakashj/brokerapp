<?php

namespace App\Http\Resources\Api\SiteVisit;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteVisitPaginationResource extends JsonResource
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
            'data' => SiteVisitListResource::collection( $this->items() ),
            'per_page' => $this->perPage(),
            'total_records' => $this->total(),
            'first_item' => $this->firstItem(),
            'last_item' => $this->lastItem(),
        ];

        return $data;
    }
}
