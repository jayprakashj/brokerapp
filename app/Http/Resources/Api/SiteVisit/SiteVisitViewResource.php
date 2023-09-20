<?php

namespace App\Http\Resources\Api\SiteVisit;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteVisitViewResource extends JsonResource
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
            'description' => $this->description ?? 'N/A',
            'remark' => $this->remark ?? 'N/A',
            'assign_user' => 'N/A',
            'scheduled_date' => $this->scheduled_date ?? 'N/A',
            'status' => $this->status ?? 'N/A',
            'created_user_name' => $this->createdUser->name  ?? 'N/A',
            'updated_user_name' => $this->updatedUser->name ?? 'N/A',
            'created_at_time' => $this->created_at->format('d-m-Y h:i a'),
            'updated_at_time' => $this->created_at->format('d-m-Y h:i a'),
        ];

        if( !is_null( $this->assignToUser ) ){
            $data['assign_user'] = $this->assignToUser->name;
        }
        return $data;
    }
}
