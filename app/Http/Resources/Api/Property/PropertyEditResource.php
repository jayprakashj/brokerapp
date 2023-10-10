<?php

namespace App\Http\Resources\Api\Property;

use App\Models\PropertyImageTypeList;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyEditResource extends JsonResource
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
            'name' => $this->name,
            'property_type' => $this->property_type,
            'property_transaction' => $this->property_transaction,
            'property_furnishing' => $this->property_furnishing,
            'property_facing' => $this->property_facing,
            'property_obligation' => $this->property_obligation,
            'building_name' => $this->building_name,
            'unit_no' => $this->unit_no,
            'is_verified' => $this->isVerified(),
            'is_document_verified' => $this->isDocumentVerified(),
            'address' => $this->address,
            'city' => $this->city,
            'locality' => $this->locality,
            'description' => $this->description,
            'remark' => $this->remark,
            'internal_note' => $this->internal_note,
            'unique_feature' => $this->unique_feature,
            'suitable_for' => $this->suitable_for,
            'bedrooms' => $this->bedrooms,
            'master_bedrooms' => $this->master_bedrooms,
            'guest_room' => $this->guest_room,
            'child_room' => $this->child_room,
            'other_room' => $this->other_room,
            'bathrooms' => $this->bathrooms,
            'common_bathrooms' => $this->common_bathrooms,
            'ensult_bathrooms' => $this->ensult_bathrooms,
            'sellable_area' => $this->sellable_area,
            'builtup_area' => $this->builtup_area,
            'carpet_area' => $this->carpet_area,
            'plot_area' => $this->plot_area,
            'terrace_area' => $this->terrace_area,
            'area_range' => $this->area_range,
            'price' => $this->price,
            'negotiable_amount' => $this->negotiable_amount,
            'security_deposit' => $this->security_deposit,
            'property_floor' => $this->property_floor,
            'total_floor' => $this->total_floor,
            'property_facing' => $this->property_facing,
            'lease_period' => $this->lease_period,
            'lease_expiry_date' => $this->lease_expiry_date,
            'availability' => $this->availability,
            'ownership' => $this->ownership,
            'no_of_parking' => $this->no_of_parking,
            'no_of_lift' => $this->no_of_lift,
            'age_of_property' => $this->age_of_property,
            'workstation' => $this->workstation,
            'conference_room' => $this->conference_room,
            'reception' => $this->reception,
            'walk_through_link' => $this->walk_through_link,
            'amenities' => $this->amenities,
            'owner_name' => $this->owner_name,
            'owner_email' => $this->owner_email,
            'owner_phone' => $this->owner_phone,
            'refer_by_name' => $this->refer_by_name,
            'refer_by_email' => $this->refer_by_email,
            'refer_by_phone' => $this->refer_by_phone,
            'notification_start_date' => $this->notification_start_date,
            'notification_end_date' => $this->notification_end_date,
            'notification_message' => $this->notification_message,
            'images' => []
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
        return $data;
    }
}
