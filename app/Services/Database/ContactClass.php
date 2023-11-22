<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\CompanyBranch;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

class ContactClass {

    private $customerTypeClass;
    private $contactTypeClass;

    public function __construct()
    {
        $this->customerTypeClass = new CustomerTypeClass;
        $this->contactTypeClass = new ContactTypeClass;
    }

    public function getDefaultList ( $request ) {
        $lists = Contact::with([
                    'company',
                    'updatedUser',
                    'contactType',
                    'customerType'
                ])
                ->customFilter( $request->input('filter') )
                ->customSort( $request->input('sort_by'), $request->input('sort_order'))
                ->paginate( $request->input('per_page', config('app.per_page') ) );

        return $lists;
    }

    public function findByMobile ( $mobile ){
        return Contact::whereMobile( $mobile )->first();
    }

    public function findByEmail ( $email ){
        return Contact::whereEmail( $email )->first();
    }

    public function create ( User $user, $request ) {

        $contact = new Contact();
        $contact->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $contact->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $contact->created_by = $user->id;
        $contact = $this->createOrUpdate( $contact, $user, $request );


        return $contact;
    }

    public function update ( User $user, Contact $contact, $request ){
        return $this->createOrUpdate( $contact, $user, $request );
    }

    public function createOrUpdate( Contact $contact, User $user, $request ){
        $contact->name = $request->input('name');
        $contact->name_prefix = $request->input('name_prefix');
        $contact->country_code = $request->input('country_code', 91);
        $contact->mobile = $request->input('mobile');
        $contact->is_whatsapp_available = $request->filled('is_whatsapp_available') && $request->input('is_whatsapp_available') == 1 ? 1 : 0;
        $contact->other_contact_country_code = $request->input('other_contact_country_code');
        $contact->other_contact_no = $request->input('other_contact_no');
        $contact->email = $request->input('email');
        $contact->is_email_verified = $request->filled('is_email_verified') && $request->input('is_email_verified') == 1 ? 1 : 0;
        $contact->gender = $request->input('gender');
        $contact->address = $request->input('address');
        $contact->city = $request->input('city');
        $contact->locality = $request->input('locality');
        $contact->pincode = $request->input('pincode');
        $contact->company_name = $request->input('company_name');
        $contact->occupation = $request->input('occupation');
        $contact->designation = $request->input('designation');
        $contact->birth_date = $request->input('birth_date');
        $contact->website = $request->input('website');
        $contact->enable_whatsapp_wishes = $request->filled('enable_whatsapp_wishes') && $request->input('enable_whatsapp_wishes') == 1 ? 1 : 0;
        $contact->enable_sms_wishes = $request->filled('enable_sms_wishes') && $request->input('enable_sms_wishes') == 1 ? 1 : 0;
        $contact->enable_email_wishes = $request->filled('enable_email_wishes') && $request->input('enable_email_wishes') == 1 ? 1 : 0;
        $contact->comment = $request->input('comment');
        $contact->updated_by = $user->id;
        $contact->customer_type_id = $this->customerTypeClass->findOrCreate( $user, $request->input('customer_type') )->id ?? null;
        $contact->contact_type_id = $this->contactTypeClass->findOrCreate( $user, $request->input('contact_type') )->id ?? null;
        $contact->save();


        if( $request->filled('logo') ){
            $logoFile = 'tmp_media/' . $request->input('logo');
            if( Storage::disk('public')->has( $logoFile ) ){
                $contact->addMediaFromDisk( $logoFile, 'public')->toMediaCollection('logo');
            }
        }
        if( !$contact->wasRecentlyCreated ){
            $contact->refresh();

        }

        return $contact;
    }

}
