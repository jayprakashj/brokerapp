<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Document\AddDocumentRequest;
use App\Http\Resources\Api\Document\DocumentEditResource;
use App\Http\Resources\Api\Document\DocumentPaginationResource;
use App\Models\Document;
use App\Models\Property;
use App\Services\Database\DocumentClass;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    private $documentClass;

    public function __construct( )
    {
        $this->documentClass = new DocumentClass;
    }

    public function index ( Request $request ) {

        $lists = $this->documentClass->getDefaultCompanyDocuments( $request->input('per_page', 24 ));
        return new DocumentPaginationResource( $lists );
    }

    public function edit (Document $document ) {

        return new DocumentEditResource( $document );
    }

    public function store (AddDocumentRequest $request ) {
        $response = [
            'message' => 'Success! New Document added successfully.'
        ];
        $code = 200;

        $document = Document::find( $request->input('id') );

        if( is_null( $document ) ){
            $this->documentClass->create( auth()->user(), $request );

        }else{
            $this->documentClass->update( auth()->user(), $document, $request );
            $response = [
                'message' => 'Success! Document data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( Document $document ) {
        $code = 500;
        $document->delete();
        $response = [
            'message' => 'Document removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

    public function attachDocument ( Request $request ) {
        $property = Property::find( $request->input('property_id') );
        $document = Document::with('media')->find( $request->input('document_id') );
        $code = 500;
        $response = [
            'message' => 'Document removed successfully.'
        ];
        if( !is_null( $property ) ){
            if( !is_null( $document ) ){
                $isExists = Document::wherePropertyId( $property->id )
                                    ->whereDocumentId( $document->id )
                                    ->first();
                if( is_null( $isExists ) ){

                    $this->documentClass->attachDocumentWithProperty( $document, $property, auth()->user() );

                    $response = [
                        'message' => 'Success! Document attached successfully.'
                    ];
                    $code = 200;
                }else{

                    $response = [
                        'message' => 'Error! Document already attached with selected property.'
                    ];
                }
            }else{
                $response = [
                    'message' => 'Error! Document not exists.'
                ];
            }

        }else{
            $response = [
                'message' => 'Error! Property not exists.'
            ];

        }
        return response()->json( $response , $code);
    }


    public function deletePropertyDocument ( Document $document ) {
        $code = 500;
        if( !is_null( $document->property_id ) ){
            $document->delete();

            $response = [
                'message' => 'Document removed successfully.'
            ];
            $code = 200;
        }else{

            $response = [
                'message' => 'Error! Invalid request.'
            ];
        }
        return response()->json( $response , $code);
    }
}
