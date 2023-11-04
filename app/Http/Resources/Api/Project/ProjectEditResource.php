<?php

namespace App\Http\Resources\Api\Project;

use App\Models\PropertyImageTypeList;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $propertyImgTypes = PropertyImageTypeList::select('id', 'name')->pluck('name')->toArray();
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'rera_reg_no' => $this->rera_reg_no,
            'project_no' => $this->project_no,
            'launch_date' => $this->launch_date,
            'completion_date' => $this->completion_date,
            'company_branch' => $this->company_branch_id,
            'project_area' => $this->project_area,
            'developer_name' => $this->developer_name,
            'approved_by' => $this->approved_by,
            'open_space' => $this->open_space,
            'total_unit' => $this->total_unit,
            'availability' => $this->availability,
            'availability_date' => $this->availability_date,
            'commencement_certificate' => $this->commencement_certificate,
            'occupancy_certificate' => $this->occupancy_certificate,
            'specification' => $this->specification,
            'description' => $this->description,
            'remark' => $this->remark,
            'landmark' => $this->landmark,
            'city' => $this->city,
            'locality' => $this->locality,
            'building' => $this->building,
            'address' => $this->address,
            'amenities' => $this->amenities,
            'owner_name' => $this->owner_name,
            'owner_email' => $this->owner_email,
            'owner_phone' => $this->owner_phone,
            'assign_to' => $this->assign_to,
            'walk_through_link' => $this->walkthrough_link,
            'virtual_tour' => $this->virtual_tour,
            'project_towers' => $this->projectTowers->map->only(['id','tower_name', 'completion_date']),
            'project_plans' => $this->projectPlans->map->only(['id','tower', 'type','bhk','area', 'price','basic_price']),
            'project_charges' => $this->projectCharges->map->only(['id','charges', 'description', 'price', 'escalation_from']),
        ];


        if( !is_null( $this->assign_to ) ){
            $data['assign_user_data'] = $this->assignToUser->only(['id', 'name']);
        }
        if( !is_null( $this->companyBranch ) ){
            $data['company_branch_data'] = $this->companyBranch->only(['id', 'name']);
        }

        $isMediaExists = $this->media->count() > 0;
        $media = $this->media->groupBy('collection_name');
        $images = [];
        $documents = [];

        foreach( $propertyImgTypes as $collectionType ){
            if( $isMediaExists && $media->has( $collectionType )){

                $images[ $collectionType ] = $media[$collectionType]->map( function( $data ){
                    $res = [
                        'id' => $data->id,
                        'url' => $data->getUrl('icon')
                    ];
                    return $res;
                });
            }else{
                $images[ $collectionType ] = [];
            }
        }
        $data['images'] = $images;

        if( $media->has( 'documents' ) ){
            foreach( $media['documents'] as $item ){

                $documents[]  = [
                    'id' => $item->id,
                    'name' => $item->file_name,
                    'url' => $item->getUrl()
                ];
            }
        }

        $data['documents'] = $documents;
        return $data;
    }
}
