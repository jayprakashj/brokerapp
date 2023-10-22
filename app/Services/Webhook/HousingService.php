<?php

namespace App\Services\Webhook;

use App\Models\LeadSource;

class HousingService extends CommonService {

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
        $this->log->error('HOUSING.com-LEAD:REQUEST_DATA - ' . json_encode( $request->all(), true ));
        $defaultData = [
            'lead_source' => LeadSource::where('name', 'LIKE', '%Housing%')->first()->name ?? 'Housing.com',
            'comment' => 'This lead is auto generated from the Housing.com'
        ];

        $request->merge( $defaultData );

        return [$request->all()];
    }
}
