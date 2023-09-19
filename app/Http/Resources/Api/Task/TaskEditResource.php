<?php

namespace App\Http\Resources\Api\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskEditResource extends JsonResource
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
            'description' => $this->description,
            'remark' => $this->remark,
            'assign_to' => $this->assign_to,
            'scheduled_date' => $this->scheduled_date,
            'status' => $this->status,
        ];

        if( !is_null( $this->assignToUser ) ){
            $data['assign_user_data'] = $this->assignToUser->only(['id', 'name']);
        }
        return $data;
    }
}
