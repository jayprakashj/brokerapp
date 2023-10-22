<?php

namespace App\Services\Webhook;

use App\Models\LeadSource;

class NinetyNineAcresService extends CommonService {

    public function isVerificationRequest( $request ){

        return false;
    }

    public function getVerificationToken( $request ){

        return false;
    }

    public function getVerifyResponseCode( $request ){

        return false;
    }

    public function getLeadData( $request ){
        $this->log->error('99ACRES-LEAD:REQUEST_DATA - ' . json_encode( $request->all(), true ));
        $defaultData = [
            'lead_source' => LeadSource::where('name', 'LIKE', '%99Acres%')->first()->name ?? '99Acres.com',
            'comment' => 'This lead is auto generated from the 99Acres.com'
        ];

        $request->merge( $defaultData );

        return [$request->all()];
    }
}
