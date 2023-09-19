<?php

namespace App\Http\Resources\Api\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskListResource extends JsonResource
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
            'title' => $this->title ?? 'N/A',
            'company_name' => $this->company->name ?? 'N/A',
            'scheduled_date' => $this->scheduled_date ?? 'N/A',
            'assign_user' => $this->assignToUser->name ?? 'N/A',
            'status' => $this->status ?? 'N/A',

        ];

        return $data;
    }
}
