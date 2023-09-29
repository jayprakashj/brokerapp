<?php

namespace App\Http\Resources\Api\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadListResource extends JsonResource
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
            'title' => $this->title,
            'name' => $this->customer_name,
            'mobile' => $this->customer_mobile ?? 'N/A',
            'email' => $this->customer_email ?? 'N/A',
            'status' => $this->lead_status ?? 'N/A',
            'comment' => $this->lastComment->comment ?? 'N/A',
            'updated_at' => $this->updated_at->format('d M, Y h:i a')

        ];

        return $data;
    }
}
