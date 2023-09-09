<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\AddContactRequest;
use App\Http\Requests\Api\Document\AddDocumentRequest;
use App\Http\Resources\Api\Contact\ContactEditResource;
use App\Http\Resources\Api\Contact\ContactPaginationResource;
use App\Http\Resources\Api\Document\DocumentEditResource;
use App\Http\Resources\Api\Document\DocumentPaginationResource;
use App\Models\Contact;
use App\Models\Document;
use App\Services\Database\ContactClass;
use App\Services\Database\ContactTypeClass;
use App\Services\Database\CustomerTypeClass;
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
}
