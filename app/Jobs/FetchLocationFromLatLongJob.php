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

            $client = new Client();

            $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat. ',' . $long .'&key=' . config('services.google_map.api_key');

            try{

                $req = $client->get( $url, ['verify' => false] );

                $response = $req->getBody()->getContents();
                $response = json_decode( $response, true );

                $results = data_get( $response, 'results');
                $result = head( $results );
                $formattedAddress = data_get( $result, 'formatted_address');
                $addressComponent = data_get( $result, 'address_components', []);

                $address = [];
                $locality = null;
                $city = null;
                $country = null;
                foreach( $addressComponent as $item ){
                    $types = data_get( $item, 'types', []);
                    $typeName = data_get( $item, 'long_name', []);
                    if( in_array('country', $types ) ){
                        $country = $typeName;
                    }
                    if( in_array('locality', $types ) ){
                        $locality = $typeName;
                    }
                    if( in_array('administrative_area_level_3', $types ) ){
                        $city = $typeName;
                    }
                    if( in_array('route', $types ) || in_array('neighborhood', $types ) || in_array('sublocality', $types )  ){
                        $address[] = $typeName;
                    }
                }
                if( !empty( $address ) ){
                    $address = implode( ', ', $address );
                }

                $memberLocation = $this->memberLocation;
                $memberLocation->formatted_address = $formattedAddress;
                $memberLocation->address = $address;
                $memberLocation->locality = $locality;
                $memberLocation->city = $city;
                $memberLocation->country = $country;
                $memberLocation->response = json_encode( $results, true );
                $memberLocation->save();

            }catch( \Exception $e ){
                info( 'ERROR IN GOOGLE MAP API' );
                info( $e );
            }

        }
    }
}
