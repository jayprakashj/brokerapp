<?php

namespace App\Http\Resources\Api\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleEditResource extends JsonResource
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
            'role_name' => $this->name,
            'hierarchy_order' => $this->hierarchy_order,
            'permissions' => $this->permissions->pluck('id')->toArray(),
        ];

        return $data;
    }
}
