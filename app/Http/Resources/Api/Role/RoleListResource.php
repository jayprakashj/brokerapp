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
            'permissions_count' => $this->permissions_count,
            'members' => $this->users->pluck('name'),
            'permissions' => $this->permissions->pluck('name'),
            'updated_at_time' => $this->updated_at->format('d-m-Y h:i a'),
        ];

        return $data;
    }
}
