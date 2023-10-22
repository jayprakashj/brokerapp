<?php

namespace App\Services\Webhook;

use App\Models\LeadSource;
use FacebookAds\Api;
use Illuminate\Support\Arr;
use Throwable;

class FacebookService extends CommonService{

    /**
     * https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration
     *
     *
     */



    private $fbApi;

    public function isVerificationRequest( $request ){

        return $request->filled('hub_challenge');
    }

    public function getVerificationToken( $request ){

        return $request->input('hub_verify_token');
    }

    public function getVerifyResponseCode( $request ){
        return $request->input('hub_challenge');

    }

    public function getLeadData( $request ){
        $data = [];
        $requestData = $request->all();
        $entry = data_get( $requestData, 'entry' );
        if( !empty( $entry ) ){
            $this->initApiInstance();
            foreach( $entry as $item ){
                $changes = data_get( $item, 'changes', [] );
                if( !empty( $changes ) ){

                    foreach( $changes as $changeItem ){
                        $fieldName = data_get( $changeItem, 'field');
                        if( $fieldName == 'leadgen' ){
                            $leadGenData = data_get( $changeItem, 'value' );
                            $formId = data_get( $leadGenData, 'form_id' );
                            $leadGenId = data_get( $leadGenData, 'leadgen_id' );
                            $this->log->info('FACEBOOK-LEAD:LEADGEN_ID: ' . $leadGenId );
                            $leadData = $this->fetchLeadData( $leadGenId, $formId );
                            if( !empty( $leadData ) ){
                                $data[] = $leadData;

                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function initApiInstance(){
        if( empty( $this->fbApi ) ){
            Api::init(
                config('services.facebook_ads.app_id'),
                config('services.facebook_ads.app_secret'),
                config('services.facebook_ads.access_token')
            );
            $this->fbApi = Api::instance();
        }
    }

    public function fetchLeadData ( $leadId = null, $formId = null ){
        $data = [];
        if( !is_null( $leadId ) ){
            $formData = [];
            if( !empty( $formId ) ){
                $this->log->info('FACEBOOK-LEAD:FORM_ID: ' . $formId );
                $formData = $this->fetchFormData( $formId );
            }
            try{
                $lead = $this->fbApi->call( '/'.$leadId );
                $leadData = $lead->getBOdy();
                $leadData = json_decode( $leadData, true );
                $fieldData = data_get( $leadData , 'field_data', []);
                if( !empty( $fieldData ) ){

                    $this->log->info('FACEBOOK-LEAD:LEAD_FIELD_DATA: ' . json_encode( $fieldData, true ) );

                    foreach( $fieldData as $item ){
                        $fieldName = data_get( $item, 'name');
                        $values = data_get( $item, 'values');
                        $leadArr[ $fieldName ] = head( $values );
                    }
                    $remark = null;
                    $otherFormField = Arr::except( $leadArr, [ 'full_name', 'email','phone_number', 'city']);
                    if( !empty( $otherFormField ) ){
                        $otherFormField = \Helper::convertChangesData( $otherFormField );
                        $formFields = \Helper::combineKeyValue( $otherFormField );
                        $remark = 'Facebook Lead Form Data:';
                        $remark .= "\r\n" . implode( "\n", $formFields );
                    }
                    $data = [
                        'lead_source' => LeadSource::where('name', 'LIKE', '%facebook%')->first()->name ?? 'Facebook',
                        'comment' => 'This lead is auto generated from the Facebook',
                        'title' => 'Facebook Lead - ' . $leadId . ' ' .data_get( $formData, 'name' ),
                        'name' => data_get( $leadArr, 'full_name'),
                        'email' => data_get( $leadArr, 'email'),
                        'mobile' => data_get( $leadArr, 'phone_number'),
                        'city' => data_get( $leadArr, 'city'),
                        'remark' => $remark,
                    ];
                    if( !empty( $data['mobile'] ) ){
                        $data['mobile'] = substr( $data['mobile'], -10 );
                    }
                }else{
                    $this->log->error('FACEBOOK-LEAD:EMPTY: No data found for lead');
                }
            }catch( Throwable $th ){
                $this->log->error('FACEBOOK-LEAD:ERR_LEAD: ' . $th->getMessage() );
            }
        }
        return $data;
    }

    public function fetchFormData ( $formId = null ){
        if( !empty( $formId ) ){
            try{

                $form = $this->fbApi->call( '/'.$formId );
                $formData = $form->getBOdy();
                $formData = json_decode( $formData, true );
                return $formData;
            }catch( Throwable $th ){
                $this->log->error('FACEBOOK-LEAD:ERR-FORM-DATA: No data available for selected form ( ' . $th->getMessage() . ' )');
            }
        }
        return null;
    }

}
