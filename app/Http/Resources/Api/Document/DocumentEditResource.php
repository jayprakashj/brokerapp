<?php

namespace App\Http\Resources\Api\Document;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentEditResource extends JsonResource
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
            'property_id' => $this->property_id,
            'property_name' => $this->property->name ?? null,
            'name' => $this->name,
            'description' => $this->description,
            'content' => $this->content,
            'attachment' => null,
            'attachment_url' => null,
        ];

        $media = $this->media;
        if( $media->count() ){
            $attachment = $media->first();
            $data['attachment'] = $attachment->id;
            $data['attachment_url'] = $attachment->getUrl();
        }
        return $data;
    }
}
