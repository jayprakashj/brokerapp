<?php

namespace App\Services;

use App\Models\User;
use NumberFormatter;
use App\Models\Company;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class HelperService {

    public function convertArrayIntoAssociative ( $data = [], $idKey = 'id', $labelKey = 'title' ){
        $resArr = [];
        foreach( $data as $key => $value ){
            $tmp = [
                $idKey => $key,
                $labelKey => $value,
            ];
            $resArr[] = $tmp;
        }
        return $resArr;
    }

    public function formatAmount ( $amount, $withSymbol = true, $useMoneyFormat = false ){

        if( $useMoneyFormat ){
            $numFormat = new \NumberFormatter('en_IN', NumberFormatter::DECIMAL);
            if( $withSymbol ){
                $numFormat = new \NumberFormatter('en_IN', NumberFormatter::CURRENCY);
            }
            return $numFormat->formatCurrency( (float)$amount, 'INR' );
        }

        if( is_numeric( $amount ) ){
            $amount = number_format( $amount, 2 );
            if( $withSymbol ){
                $amount = config('app.currency_symbol') . ' ' . $amount;
            };
        }
        return $amount;
    }

    public function setDefaultCompanySessionTeam ( User $user = null ){
        if( is_null( $user ) ){
            $user = auth()->user();
        }
        $defaultCompany = $user->retrieveDefaultCompany();
        if( !is_null( $defaultCompany )){
            setPermissionsTeamId( $defaultCompany->id );
        }
    }

    public function hasGlobalPermission ( $permission, $guard = null ) {
        return auth()->user()->hasGlobalPermission( $permission, $guard );
    }

    public function retrieveDefaultCompany(){
        $user = auth()->user();
        if( $user ){
            $defaultCompany = $user->retrieveDefaultCompany();
            if( !is_null( $defaultCompany ) ){
                return $defaultCompany;
            }
        }else{
            return Company::first();
        }

        return null;
    }

    public function combineKeyValue( $data ){
        $result = [];
        if( !empty( $data ) ){
            foreach( $data as $key => $value ){
                $result[] = $key . ' : ' . $value;
            }
        }

        return $result;
    }

    public function convertChangesData( $data ){
        $result = [];
        if( !empty( $data ) ){
            foreach( $data as $key => $value ){
                $key = Str::title(Str::replace('_', ' ', $key ));
                if( is_array( $value ) ){
                    $value = implode( ', ', $value );
                }
                $result[$key] = $value;
            }
        }

        return $result;
    }

    public function getGoogleAddressFromLatLong( $lat, $lng ){
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $lat. ',' . $lng .'&key=' . config('services.google_map.api_key');

        $response = null;

        $client = new Client();

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
            }else{
                $address = null;
            }

            $response = [
                '__response' => $response,
                '__response_results' => $results,
                '__address_components' => $addressComponent,
                'formatted_address' => $formattedAddress,
                'address' => $address,
                'locality' => $locality,
                'city' => $city,
                'country' => $country,
            ];

        }catch( \Exception $e ){
            info( 'ERROR IN GOOGLE MAP API' );
            info( $e );
        }

        return $response;
    }
}
