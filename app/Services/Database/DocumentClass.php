<?php

namespace App\Services\Database;

use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DocumentClass {


    public function __construct()
    {
    }

    public function getDefaultCompanyDocuments ( $perPage = 24 ) {

        $lists = Document::query()->with(['company'])->whereNull('property_id');
        $lists = $lists->paginate( $perPage );

        return $lists;
    }


    public function create ( User $user, $request ) {

        $document = new Document();
        $document->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $document->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $document->created_by = $user->id;
        $document = $this->createOrUpdate( $document, $user, $request );


        return $document;
    }

    public function update ( User $user, Document $document, $request ){
        return $this->createOrUpdate( $document, $user, $request );
    }

    public function createOrUpdate( Document $document, User $user, $request ){

        $document->name = $request->input('name');

        $document->description = $request->input('description');
        $document->content = $request->input('content');

        $document->updated_by = $user->id;

        $document->save();

        $images = $request->input('attachment');


        if( $request->filled('attachment') ){
            $attachmentFile = 'tmp_media/' . $request->input('attachment');
            if( Storage::disk('public')->has( $attachmentFile ) ){
                $document->addMediaFromDisk( $attachmentFile, 'public')->toMediaCollection();
            }
        }else{
            $document->clearMediaCollection();
        }

        if( !$document->wasRecentlyCreated ){
            $document->refresh();

        }

        return $document;
    }


}
