<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\Property;
use App\Models\PropertyFacingList;
use App\Models\PropertyFurnishList;
use App\Models\PropertyObligationList;
use App\Models\PropertySubTypeList;
use App\Models\PropertyTransactionList;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PropertyClass {


    public function __construct()
    {
    }

    public function getDefaultCompanyProperties ( $request, $onlyAssignedTo = false) {

        $lists = Property::query()->with(['company','companyBranch', 'assignToUser', 'updatedUser']);
        if( $onlyAssignedTo ){
            $lists->createdByOrAssignToAuth();
        }
        $lists = $lists->customFilter( $request->input('filter') )
                        ->customSort( $request->input('sort_by'), $request->input('sort_order'))
                        ->paginate( $request->input('per_page', config('app.per_page') ) );

        return $lists;
    }


    public function create ( User $user, $request ) {

        $property = new Property();
        $property->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $property->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $property->created_by = $user->id;
        $property = $this->createOrUpdate( $property, $user, $request );


        return $property;
    }

    public function update ( User $user, Property $property, $request ){
        return $this->createOrUpdate( $property, $user, $request );
    }

    public function createOrUpdate( Property $property, User $user, $request ){

        $property->name = $request->input('name');

        $property->company_branch_id = $request->input('company_branch');
        $property->assign_to = $request->input('assign_to');

        $property->property_type = PropertySubTypeList::whereName( $request->input('property_type') )->first()->name;
        $property->property_transaction = PropertyTransactionList::whereName( $request->input('property_transaction') )->first()->name;
        $property->property_furnishing = PropertyFurnishList::whereName( $request->input('property_furnishing') )->first()->name ?? null;
        $property->property_facing = PropertyFacingList::whereName( $request->input('property_facing') )->first()->name ?? null;
        $property->property_obligation = PropertyObligationList::whereName( $request->input('property_obligation') )->first()->name ?? null;

        $property->building_name = $request->input('building_name');
        $property->unit_no = $request->input('unit_no');
        $property->is_verified = ($request->filled('is_verified') && $request->is_verified == Property::IS_VERIFIED_YES) ? Property::IS_VERIFIED_YES: Property::IS_VERIFIED_NO;
        $property->is_document_verified = ($request->filled('is_document_verified') && $request->is_document_verified == Property::IS_DOCUMENT_VERIFIED_YES )? Property::IS_DOCUMENT_VERIFIED_YES: Property::IS_DOCUMENT_VERIFIED_NO;
        $property->address = $request->input('address');
        $property->city = $request->input('city');
        $property->locality = $request->input('locality');
        $property->description = $request->input('description');
        $property->remark = $request->input('remark');
        $property->internal_note = $request->input('internal_note');
        $property->unique_feature = $request->input('unique_feature');
        $property->suitable_for = $request->input('suitable_for');
        $property->bedrooms = $request->input('bedrooms');
        $property->master_bedrooms = $request->input('master_bedrooms');
        $property->guest_room = $request->input('guest_room');
        $property->child_room = $request->input('child_room');
        $property->other_room = $request->input('other_room');
        $property->bathrooms = $request->input('bathrooms');
        $property->common_bathrooms = $request->input('common_bathrooms');
        $property->ensult_bathrooms = $request->input('ensult_bathrooms');
        $property->sellable_area = $request->input('sellable_area');
        $property->builtup_area = $request->input('builtup_area');
        $property->carpet_area = $request->input('carpet_area');
        $property->plot_area = $request->input('plot_area');
        $property->terrace_area = $request->input('terrace_area');
        $property->area_range = $request->input('area_range');
        $property->price = $request->input('price');
        $property->negotiable_amount = $request->input('negotiable_amount');
        $property->security_deposit = $request->input('security_deposit');
        $property->property_floor = $request->input('property_floor');
        $property->total_floor = $request->input('total_floor');
        $property->property_facing = $request->input('property_facing');
        $property->lease_period = $request->input('lease_period');
        $property->lease_expiry_date = $request->input('lease_expiry_date');
        $property->availability = $request->input('availability');
        $property->ownership = $request->input('ownership');
        $property->no_of_parking = $request->input('no_of_parking');
        $property->no_of_lift = $request->input('no_of_lift');
        $property->age_of_property = $request->input('age_of_property');
        $property->workstation = $request->input('workstation');
        $property->conference_room = $request->input('conference_room');
        $property->reception = $request->input('reception');
        $property->walk_through_link = $request->input('walk_through_link');
        $property->amenities = $request->input('amenities');
        $property->owner_name = $request->input('owner_name');
        $property->owner_email = $request->input('owner_email');
        $property->owner_phone = $request->input('owner_phone');
        $property->refer_by_name = $request->input('refer_by_name');
        $property->refer_by_email = $request->input('refer_by_email');
        $property->refer_by_phone = $request->input('refer_by_phone');
        $property->updated_by = $user->id;
        $property->notification_start_date = $request->input('notification_start_date');
        $property->notification_end_date = $request->input('notification_end_date');
        $property->notification_message = $request->input('notification_message');

        if( $property->isDirty( 'assign_to' ) ){
            $property->assign_date = today();
        }

        $property->save();

        $images = $request->input('images');

        if( !empty( $images ) && is_array( $images )){
            $mediaId = Arr::pluck( Arr::flatten($request->images,1), 'id');

            $removedMedia = $property->media()->whereNotIn( 'id', $mediaId )->whereNotIn('collection_name',['documents'])->get();
            if( $removedMedia->count() ){
                foreach( $removedMedia as $item ){
                    $property->deleteMedia( $item );
                }
            }
            foreach( $images as $imgType => $files ){
                if( !empty( $files ) ){
                    foreach( $files as $fileName ){
                        $tmpFileNm = data_get( $fileName, 'id');
                        if( !empty( $tmpFileNm ) ){

                            $tmpFile = 'tmp_media/' . $tmpFileNm;
                            if( Storage::disk('public')->has( $tmpFile ) ){
                                $property->addMediaFromDisk( $tmpFile, 'public')->toMediaCollection( $imgType );
                            }
                        }
                    }
                }
            }
        }else{
            $property->clearMediaCollectionExcept('documents');
        }

        $documents = $request->input('documents');

        if( !empty( $documents ) && is_array($documents)){
            $documentsId = Arr::pluck( $documents, 'id');

            $removeDocuments = $property->media()
                                    ->where('collection_name','documents')
                                    ->whereNotIn( 'id', $documentsId )
                                    ->get();

            if( $removeDocuments->count() ){
                foreach( $removeDocuments as $item ){
                    $property->deleteMedia( $item );
                }
            }

            foreach( $documents as $fileName ){
                $tmpFileNm = data_get( $fileName, 'id');
                if( !empty( $tmpFileNm ) ){

                    $tmpFile = 'tmp_media/' . $tmpFileNm;
                    if( Storage::disk('public')->has( $tmpFile ) ){
                        $property->addMediaFromDisk( $tmpFile, 'public')->toMediaCollection( 'documents' );
                    }
                }
            }
        }else{
            $property->clearMediaCollection('documents');
        }

        if( !$property->wasRecentlyCreated ){
            $property->refresh();

        }

        return $property;
    }


}
