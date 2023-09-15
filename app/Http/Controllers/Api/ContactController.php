<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\AddContactRequest;
use App\Http\Resources\Api\Contact\ContactEditResource;
use App\Http\Resources\Api\Contact\ContactPaginationResource;
use App\Models\Contact;
use App\Services\Database\ContactClass;
use App\Services\Database\ContactTypeClass;
use App\Services\Database\CustomerTypeClass;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contactClass;
    private $contactTypeClass;
    private $customerTypeClass;

    public function __construct( )
    {
        $this->contactClass = new ContactClass;
        $this->contactTypeClass = new ContactTypeClass;
        $this->customerTypeClass = new CustomerTypeClass;
    }

    public function index ( Request $request ) {

        $branches = $this->contactClass->getDefaultList( $request->input('per_page', 24 ));
        return new ContactPaginationResource( $branches );
    }

    public function edit (Contact $contact ) {

        return new ContactEditResource( $contact );
    }

    public function store (AddContactRequest $request ) {
        $response = [
            'message' => 'Success! New Contact added successfully.'
        ];
        $code = 200;

        $contact = Contact::find( $request->input('id') );

        if( is_null( $contact ) ){
            $this->contactClass->create( auth()->user(), $request );

        }else{
            $this->contactClass->update( auth()->user(), $contact, $request );
            $response = [
                'message' => 'Success! Contact data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( Contact $contact ) {
        $code = 500;
        $contact->delete();
        $response = [
            'message' => 'Contact removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

    public function contactTypeSelectList ( Request $request ){
        $list = $this->contactTypeClass->getByName( $request->input('search'));
        // $list = $this->contactTypeClass->getLists();
        return response()->json( $list, 200 );
    }

    public function customerTypeSelectList ( Request $request ){
        $list = $this->customerTypeClass->getByName( $request->input('search'));
        // $list = $this->customerTypeClass->getLists();
        return response()->json( $list, 200 );
    }
}
