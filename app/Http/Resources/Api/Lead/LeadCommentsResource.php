<?php

namespace App\Http\Resources\Api\Lead;

use App\Http\Resources\Api\CompanyBranch\BranchListForSelectList;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadCommentsResource extends JsonResource
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
            'comment' => $this->title,
            'created_user' => $this->createdUser->name,
            'created_time' => $this->created_at->format('d-m-Y h:i a'),
            'followup_date' => $this->followup_date,
            'status' => $this->lead_status,
            'comment' => $this->comment
        ];

        return $data;
    }
}
