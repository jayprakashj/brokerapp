<?php

namespace App\Http\Resources\Api\Company;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyPaginationResource extends JsonResource
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
            'data' => CompanyListResource::collection( $this->items() ),
            'per_page' => $this->perPage(),
            'total_records' => $this->total(),
        ];

        return $data;
    }
}
