<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SpatiePermission;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Lead;

class DashboardController extends Controller
{
    public function __construct( )
    {

    }


    /**
     * @name uploadMedia
     *
     * Upload media for the temparory
     */
    public function uploadMedia ( Request $request ){
        if( $request->has('media') ){

            $contentPath = storage_path('app/public/tmp_media');

            if( !file_exists( $contentPath ) ){
                mkdir( $contentPath, 0777, true );
            }
            $files = $request->file('media');
            $uploadedFiles = [];
            foreach( $files as $file ){
                $fileExtension = $file->getClientOriginalExtension();
                $name = $file->getClientOriginalName();
                $name = str_replace( '.'. $fileExtension, '', $name);
                $name .= '_'  . time() . Str::random(5) . '.' . $fileExtension;
                if( $file->move( $contentPath, $name ) ){
                    $uploadedFiles[] = [
                        'id' => $name,
                        'url' => url('storage/tmp_media/' . $name ),
                    ];
                }
            }
            $data = [
                'files' => $uploadedFiles
            ];
            return response()->json( $data, 200);
        }else{
            return false;
        }
    }

    public function loadVueApp (){

        $globalPermissions = [];
        if( auth()->user() ){

            $globalPermissions = SpatiePermission::GlobalPermissions()->get()->pluck('name');
        }
        $enquiryTypes = \Helper::convertArrayIntoAssociative( Lead::ENQUIRY_TYPES );
        $namePrefixes = \Helper::convertArrayIntoAssociative( Contact::NAME_PREFIX_LIST, 'id', 'name' );
        $occupations = \Helper::convertArrayIntoAssociative( Contact::OCCUPATION_LIST, 'id', 'name' );

        return view('components.layouts.vue-app', compact( 'globalPermissions', 'enquiryTypes', 'namePrefixes', 'occupations' ) );
    }

    public function viewDashboard () {
        return view('dashboard');
    }

    public function authBroadcast(){
        return response()->json(  true, 200);
    }
}
