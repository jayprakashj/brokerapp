<?php

namespace App\Http\Resources\Api\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskStatusListForSelectList extends JsonResource
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
            'id' => $this->name,
            'name' => $this->name,

        ];

        return $data;
    }
}
