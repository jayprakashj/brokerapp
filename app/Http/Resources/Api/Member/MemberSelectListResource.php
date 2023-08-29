<?php

namespace App\Http\Resources\Api\Member;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberSelectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $name = 'N/A';
        if( $this->isMe() ){
            $name = 'Me';

        }else if( $this->memberUser ){
            $name = $this->memberUser->name;

        }
        $data = [
            'id' => $this->user_id,
            'name' => $name,
        ];

        return $data;
    }
}
