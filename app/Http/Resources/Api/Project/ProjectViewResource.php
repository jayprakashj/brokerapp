<?php

namespace App\Http\Resources\Api\Project;

use App\Models\PropertyImageTypeList;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectViewResource extends JsonResource
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
            'rera_reg_no' => $this->rera_reg_no ?? 'N/A',
            'project_no' => $this->project_no ?? 'N/A',
            'launch_date' => $this->launch_date ?? 'N/A',
            'completion_date' => $this->completion_date ?? 'N/A',
            'company_branch' => $this->company_branch_id ?? 'N/A',
            'project_area' => $this->project_area ?? 'N/A',
            'developer_name' => $this->developer_name ?? 'N/A',
            'approved_by' => $this->approved_by ?? 'N/A',
            'open_space' => $this->open_space ?? 'N/A',
            'total_unit' => $this->total_unit ?? 'N/A',
            'availability' => $this->availability ?? 'N/A',
            'availability_date' => $this->availability_date ?? 'N/A',
            'commencement_certificate' => $this->commencement_certificate ?? 'N/A',
            'occupancy_certificate' => $this->occupancy_certificate ?? 'N/A',
            'specification' => $this->specification ?? 'N/A',
            'description' => $this->description ?? 'N/A',
            'remark' => $this->remark ?? 'N/A',
            'landmark' => $this->landmark ?? 'N/A',
            'city' => $this->city ?? 'N/A',
            'locality' => $this->locality ?? 'N/A',
            'building' => $this->building ?? 'N/A',
            'address' => $this->address ?? 'N/A',
            'amenities' => $this->amenities ?? 'N/A',
            'owner_name' => $this->owner_name ?? 'N/A',
            'owner_email' => $this->owner_email ?? 'N/A',
            'owner_phone' => $this->owner_phone ?? 'N/A',
            'assign_to' => $this->assign_to ?? 'N/A',
            'assign_date' => $this->assign_date ?? 'N/A',
            'walk_through_link' => $this->walkthrough_link ?? 'N/A',
            'virtual_tour' => $this->virtual_tour ?? 'N/A',
            'project_towers' => $this->projectTowers->map->only(['id','tower_name', 'completion_date']),
            'project_plans' => $this->projectPlans->map->only(['id','tower', 'type','bhk','area', 'price','basic_price']),
            'project_charges' => $this->projectCharges->map->only(['id','charges', 'description', 'price', 'escalation_from']),
        ];


        if( !is_null( $this->assign_to ) ){
            $data['assign_user'] = $this->assignToUser->name;
        }
        if( !is_null( $this->companyBranch ) ){
            $data['company_branch'] = $this->companyBranch->name;
        }

        $isMediaExists = $this->media->count() > 0;
        $media = $this->media->groupBy('collection_name');
        $images = [];

        foreach( $propertyImgTypes as $collectionType ){
            if( $isMediaExists && $media->has( $collectionType )){

                $images = array_merge($images, $media[$collectionType]->map( function( $data ) use( $collectionType ){
                    $res = [
                        'id' => $data->id,
                        'url' => $data->getUrl('icon'),
                        'preview_url' => $data->getUrl('preview'),
                        'title' => $collectionType
                    ];
                    return $res;
                })->toArray() );
            }
        }
        $data['images'] = $images;

        return $data;
    }
}
