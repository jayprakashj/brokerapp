<?php

namespace App\Http\Resources\Api\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleListResource extends JsonResource
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
            'name' => $this->name,
            'users_count' => $this->users_count,
            'permissions' => $this->permissions->pluck('name')
        ];

        return $data;
    }
}
