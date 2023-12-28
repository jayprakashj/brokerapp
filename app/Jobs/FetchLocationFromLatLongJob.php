<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchLocationFromLatLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $memberLocation = null;

    /**
     * Create a new job instance.
     */
    public function __construct( $memberLocation )
    {
        //
        $this->memberLocation = $memberLocation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        if( $this->memberLocation ){
            $lat = $this->memberLocation->latitude;
            $long = $this->memberLocation->longitude;

            $response = \Helper::getGoogleAddressFromLatLong( $lat, $long );

            if( !empty( $response ) && is_array( $response ) ){
                $memberLocation = $this->memberLocation;
                $memberLocation->formatted_address = data_get( $response, 'formatted_address');
                $memberLocation->address = data_get( $response, 'address');
                $memberLocation->locality = data_get( $response, 'locality');
                $memberLocation->city = data_get( $response, 'city');
                $memberLocation->country = data_get( $response, 'country');
                $memberLocation->response = json_encode( data_get( $response, '__response_results', []), true );
                $memberLocation->save();
            }

        }
    }
}
