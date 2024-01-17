<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Property\AddPropertyRequest;
use App\Http\Resources\Api\Property\PropertyDocumentListResource;
use App\Http\Resources\Api\Property\PropertyDocumentResource;
use App\Http\Resources\Api\Property\PropertyEditResource;
use App\Http\Resources\Api\Property\PropertyFacingListForSelectList;
use App\Http\Resources\Api\Property\PropertyFurnishListForSelectList;
use App\Http\Resources\Api\Property\PropertyImageTypeListForSelectList;
use App\Http\Resources\Api\Property\PropertyObligationListForSelectList;
use App\Http\Resources\Api\Property\PropertyPaginationResource;
use App\Http\Resources\Api\Property\PropertySubTypeListResource;
use App\Http\Resources\Api\Property\PropertyTransactionListForSelectList;
use App\Http\Resources\Api\Property\PropertyTypeListForSelectList;
use App\Http\Resources\Api\Property\PropertyViewResource;
use App\Models\CompanyBranch;
use App\Models\Document;
use App\Models\Property;
use App\Models\PropertyFacingList;
use App\Models\PropertyFurnishList;
use App\Models\PropertyImageTypeList;
use App\Models\PropertyObligationList;
use App\Models\PropertySubTypeList;
use App\Models\PropertyTransactionList;
use App\Models\PropertyTypeList;
use App\Models\User;
use App\Services\Database\PropertyClass;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    private $propertyClass;

    public function __construct( )
    {
        $this->propertyClass = new PropertyClass;
    }

    public function index ( Request $request ) {
        $user = auth()->user();
        $onlyAssignedTo = $user->can('Only Assigned Property List');
        if( $user->isCompanyAdmin() ){
            $onlyAssignedTo = false;
        }
        $list = $this->propertyClass->getDefaultCompanyProperties( $request, $onlyAssignedTo );
        return new PropertyPaginationResource( $list );
    }

    public function edit (Property $property ) {
        if( !$property->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        return new PropertyEditResource( $property );
    }

    public function view (Property $property ) {
        if( !$property->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        $property->load([
            'latestSiteVisits' => function ( $q ){
                $q->with([
                    'companyBranch',
                    'sourceManagerUser',
                    'closingManagerUser',
                    'createdUser',
                    'updatedUser'
                ]);
            },
            'latestLeads.lastComment'
        ]);
        return new PropertyViewResource( $property );
    }

    public function store (AddPropertyRequest $request ) {
        $response = [
            'message' => 'Success! New Property added successfully.'
        ];
        $code = 200;

        $property = Property::find( $request->input('id') );

        if( is_null( $property ) ){
            $this->propertyClass->create( auth()->user(), $request );

        }else{
            if( !$property->checkAuthorization() ){
                return response()->json( [], 404 );
            }
            $this->propertyClass->update( auth()->user(), $property, $request );
            $response = [
                'message' => 'Success! Property data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( Property $property ) {
        if( !$property->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        $code = 500;
        $property->delete();
        $response = [
            'message' => 'Property removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }


    public function createFormSelectList ( Request $request ){
        $propertyTypes = PropertyTypeList::select('id', 'name')->orderBy('name')->get();
        $propertySubTypes = PropertySubTypeList::select('id', 'property_type_id', 'name')->get();
        $propertyTransactions = PropertyTransactionList::select('id', 'name')->get();
        $propertyFurnishes = PropertyFurnishList::select('id', 'name')->get();
        $propertyFacingList = PropertyFacingList::select('id', 'name')->get();
        $propertyObligations = PropertyObligationList::select('id', 'name')->get();
        $propertyImgTypes = PropertyImageTypeList::select('id', 'name')->get();
        $availabilities = \Helper::convertArrayIntoAssociative( Property::AVAILABILITIES_LIST, 'id', 'name' );

        $data = [
            'property_types' => PropertyTypeListForSelectList::collection( $propertyTypes ),
            'property_sub_types' => PropertySubTypeListResource::collection($propertySubTypes),
            'property_transactions' => PropertyTransactionListForSelectList::collection( $propertyTransactions ),
            'property_furnishes' => PropertyFurnishListForSelectList::collection( $propertyFurnishes ),
            'property_facing_list' => PropertyFacingListForSelectList::collection( $propertyFacingList ),
            'property_obligations' => PropertyObligationListForSelectList::collection( $propertyObligations ),
            'property_img_types' => PropertyImageTypeListForSelectList::collection( $propertyImgTypes ),
            'availabilities' => $availabilities,
        ];
        return response()->json( $data, 200 );
    }


    public function getPropertyFilterData ( Request $request ){
        $propertyTypes = PropertyTypeList::select('id', 'name')->orderBy('name')->get();
        $propertySubTypes = PropertySubTypeList::select('id', 'property_type_id', 'name')->get();
        $propertyTransactions = PropertyTransactionList::select('id', 'name')->get();
        $members = User::select('id', 'name')->get();
        $companyBranch = CompanyBranch::select('id', 'name')->get();
        $isVerifiedList = \Helper::convertArrayIntoAssociative( Property::IS_VERIFIED_LIST );

        $data = [
            'property_types' => PropertyTypeListForSelectList::collection( $propertyTypes ),
            'property_sub_types' => PropertySubTypeListResource::collection($propertySubTypes),
            'property_transactions' => PropertyTransactionListForSelectList::collection( $propertyTransactions ),
            'members' => $members,
            'company_branches' => $companyBranch,
            'is_verified_list' => $isVerifiedList

        ];
        return response()->json( $data, 200 );
    }

    public function getDocumentList( Property $property ){
        $property->load('documents');
        return new PropertyDocumentResource( $property );
    }

    public function getDocumentListForSelectList( Property $property ){
        $property->load('documents');
        $selectedDocuments = $property->documents->pluck('document_id')->toArray();
        $documents = Document::whereNotIn('id', $selectedDocuments )->whereNull('property_id')->get();
        return PropertyDocumentListResource::collection($documents );
    }

    public function getPropertyForSelectList(){
        $list = Property::select('id', 'name')->get();
        return response()->json( $list, 200 );
    }
}
