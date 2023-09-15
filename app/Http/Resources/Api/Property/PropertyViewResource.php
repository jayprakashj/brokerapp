<?php

namespace App\Http\Resources\Api\Property;

use App\Models\PropertyImageTypeList;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyViewResource extends JsonResource
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
            'property_furnishing' => $this->property_furnishing ?? 'N/A',
            'property_facing' => $this->property_facing ?? 'N/A',
            'property_obligation' => $this->property_obligation ?? 'N/A',
            'building_name' => $this->building_name ?? 'N/A',
            'unit_no' => $this->unit_no,
            'is_verified' => $this->isVerified(),
            'is_document_verified' => $this->isDocumentVerified(),
            'address' => $this->address,
            'city' => $this->city,
            'locality' => $this->locality,
            'description' => $this->description ?? 'N/A',
            'remark' => $this->remark ?? 'N/A',
            'internal_note' => $this->internal_note ?? 'N/A',
            'unique_feature' => $this->unique_feature ?? 'N/A',
            'suitable_for' => $this->suitable_for ?? 'N/A',
            'bedrooms' => $this->bedrooms ?? '-',
            'master_bedrooms' => $this->master_bedrooms ?? '-',
            'guest_room' => $this->guest_room ?? '-',
            'child_room' => $this->child_room ?? '-',
            'other_room' => $this->other_room ?? '-',
            'bathrooms' => $this->bathrooms ?? '-',
            'common_bathrooms' => $this->common_bathrooms ?? '-',
            'ensult_bathrooms' => $this->ensult_bathrooms ?? '-',
            'sellable_area' => $this->sellable_area ?? '-',
            'builtup_area' => $this->builtup_area ?? '-',
            'carpet_area' => $this->carpet_area ?? '-',
            'plot_area' => $this->plot_area ?? '-',
            'terrace_area' => $this->terrace_area ?? '-',
            'area_range' => $this->area_range ?? '-',
            'price' => $this->price ?? '-',
            'negotiable_amount' => $this->negotiable_amount ?? '0.00',
            'security_deposit' => $this->security_deposit ?? '0.00',
            'property_floor' => $this->property_floor ?? '-',
            'total_floor' => $this->total_floor ?? '-',
            'lease_period' => $this->lease_period ?? '-',
            'lease_expiry_date' => $this->lease_expiry_date ?? '-',
            'availability' => $this->availability ?? '-',
            'ownership' => $this->ownership ?? '-',
            'no_of_parking' => $this->no_of_parking ?? '-',
            'no_of_lift' => $this->no_of_lift ?? '-',
            'age_of_property' => $this->age_of_property ?? '-',
            'workstation' => $this->workstation ?? '-',
            'conference_room' => $this->conference_room ?? '-',
            'reception' => $this->reception ?? '-',
            'walk_through_link' => $this->walk_through_link,
            'amenities' => $this->amenities ?? '-',
            'owner_name' => $this->owner_name ?? '-',
            'owner_email' => $this->owner_email ?? '-',
            'owner_phone' => $this->owner_phone ?? '-',
            'refer_by_name' => $this->refer_by_name ?? '-',
            'refer_by_email' => $this->refer_by_email ?? '-',
            'refer_by_phone' => $this->refer_by_phone ?? '-',
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

                $images = array_merge($images,$media[$collectionType]->map( function( $data ) use( $collectionType ){
                    $res = [
                        'id' => $data->id,
                        'url' => $data->getUrl('icon'),
                        'preview_url' => $data->getUrl('preview'),
                        'title' => $collectionType
                    ];
                    return $res;
                })->toArray());
            }else{
                // $images[ $collectionType ] = [];
            }
        }
        $data['images'] = $images;
        return $data;
    }
}
