<?php

namespace App\Http\Resources\Api\Document;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentListResource extends JsonResource
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
            'name' => $this->name ?? 'N/A',
            'company_name' => $this->company->name ?? 'N/A',
            'description' => $this->description ?? 'N/A'

        ];

        return $data;
    }
}
