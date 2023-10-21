<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\Database\LeadClass;
use App\Services\Webhook\FacebookService;
use App\Services\Webhook\HousingService;
use App\Services\Webhook\MagicbrickService;
use App\Services\Webhook\MakaanService;
use App\Services\Webhook\NinetyNineAcresService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WebhookController extends Controller
{
    private $log;

    /**
     * http://brokerapp.local/webook/eyJpdiI6IlI3WVF2a0UxcytXelRvODVkdDN6Qmc9PSIsInZhbHVlIjoiRnIzcThFczlFREkrTVNLVTg1Nkw1QT09IiwibWFjIjoiM2Y5NWNlMWY0MWZlMDcxYWI5MjUwNzJkMTQyMzU3NDcxZmJjZGJjNWJiZDRiMDBlZDJkYTgyMjc2MWNlMjc5ZCIsInRhZyI6IiJ9/leads/{platform}
     *
     * FB-PAYLOAD: {
     *       "entry": {
     *           "changes": [
     *               {
     *                   "field": "leadgen",
     *                   "value": {
     *                       "form_id": "2568251756673552",
     *                       "leadgen_id": "825795579243512"
     *                   }
     *               }
     *           ]
     *       }
     *   }
     *
     *
     *
     */
    public function __construct( )
    {
        $this->log = Log::channel('webhook_lead');
    }


    public function handleWebhookLeads ( Request $request, $company, $platform ){

        $this->log->info('WEBHOOK-START:' . $platform);
        $this->log->info('WEBHOOK:REQUEST DATA' . json_encode( $request->all(), true ) );

        $allowedPlatform = [
            'magicbricks', '99acres', 'housing', 'makaan', 'facebook'
        ];

        if( in_array( $platform, $allowedPlatform ) ){

            $companyId = null;

            try{
                $companyId = Crypt::decryptString( $company );
            }catch( \Exception $e ){
                $this->log->error('WEBHOOK-ERR: INVALID COMPANY PARAM');
                return response()->json([], 404);
            }

            if( !empty( $companyId ) ){
                $company = Company::find( $companyId );
                if( !is_null( $company ) ){
                    if( !is_null( $company->owner ) ){
                        auth()->login( $company->owner );
                    }

                    $serviceObj = null;

                    switch( $platform ){
                        case 'magicbricks':
                            $serviceObj = new MagicbrickService();
                            break;
                        case '99acres':
                            $serviceObj = new NinetyNineAcresService();
                            break;
                        case 'housing':
                            $serviceObj = new HousingService();
                            break;
                        case 'makaan':
                            $serviceObj = new MakaanService();
                            break;
                        case 'facebook':
                            $serviceObj = new FacebookService();
                            break;
                    }

                    if( !is_null( $serviceObj ) ){
                        if( $serviceObj->isVerificationRequest( $request ) ){
                            $this->log->info('WEBHOOK-REQUEST: VERIFICATION REQUEST');
                            if( $serviceObj->getVerificationToken( $request ) == $company->api_verify_token ){
                                $this->log->info('WEBHOOK-REQUEST: MATCH WITH API KEY AND VERIFIED');
                                return $serviceObj->getVerifyResponseCode( $request );
                            }else{
                                $this->log->error('WEBHOOK-ERR: VERIFICATION TOKEN NOT MATCHED');
                                return null;
                            }
                        }

                        $leadData = $serviceObj->getLeadData( $request );

                        if( !empty( $leadData ) ){
                            $leadClassObj = new LeadClass;
                            $rules = [
                                'lead_source' => 'required',
                                'title' => 'required',
                                'name' => 'required',
                                'email' => 'required|email',
                                'mobile'=> 'required',
                            ];
                            foreach( $leadData as $item ){
                                $validator = Validator::make( $item, $rules );
                                if( !$validator->fails() ){
                                    $leadReqData = new Request( $item );
                                    $leadClassObj->importLeadFromWebhook( $leadReqData, $company, $company->owner );
                                    $this->log->info('WEBHOOK-SUCESS: [ DATA IMPORTED SUCCESSFULLY ] ' . json_encode($item, true) );
                                }else{
                                    $this->log->error('WEBHOOK-ERR[VALIDATION-FAILED]:' . json_encode($validator->errors()->all(), true) );
                                }
                            }
                        }else{
                            $this->log->error('WEBHOOK-ERR: LEAD DATA NOT FOUND IN REQUEST');
                        }
                    }else{
                        $this->log->error('WEBHOOK-ERR: SERVICE CLASS NOT FOUND');
                    }

                }else{
                    $this->log->error('WEBHOOK-ERR: COMPANY NOT EXISTS IN DATABASE');
                    return response()->json([], 404);
                }

            }else{
                $this->log->error('WEBHOOK-ERR: COMPANY ID IS NULL');
                return response()->json([], 404);
            }

        }else{
            $this->log->error('WEBHOOK-ERR: INVALID PLATFORM');
            return response()->json([], 404);
        }

    }

}
