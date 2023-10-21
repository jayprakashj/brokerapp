<?php

namespace App\Services\Webhook;

use App\Models\LeadSource;

class MakaanService extends CommonService {

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
        $this->log->error('MAKAAN.com-LEAD:REQUEST_DATA - ' . json_encode( $request->all(), true ));
        $defaultData = [
            'lead_source' => LeadSource::where('name', 'LIKE', '%makaan%')->first()->name ?? 'Makaan.com',
            'comment' => 'This lead is auto generated from the Makaan.com'
        ];

        $request->merge( $defaultData );

        return [$request->all()];
    }
}
