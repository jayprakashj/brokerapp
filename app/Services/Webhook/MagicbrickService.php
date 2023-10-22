<?php

namespace App\Services\Webhook;

use App\Models\LeadSource;

class MagicbrickService extends CommonService {

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
        $this->log->error('MAGICBRICK-LEAD:REQUEST_DATA - ' . json_encode( $request->all(), true ));
        $defaultData = [
            'lead_source' => LeadSource::where('name', 'LIKE', '%magicbrick%')->first()->name ?? 'MagicBricks.com',
            'comment' => 'This lead is auto generated from the MagicBricks.com'
        ];

        $request->merge( $defaultData );

        return [$request->all()];
    }
}
