<?php

namespace App\Http\Resources\Api\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupPermissionListResource extends JsonResource
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
            'name' => $this->group_name,
            'permissions' => PermissionResource::collection( $this->subPermissions )
        ];

        return $data;
    }
}
