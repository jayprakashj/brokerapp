<?php

namespace Database\Seeders;

use App\Models\MemberLocation;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MemberLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = app( Faker::class );

        $users = User::with('defaultCompany')->get();

        $latLong = [
            [
                'latitude' => '21.7659155',
                'longitude' => '70.6101682',
                'location_time' => '2023-12-11T18:30:00.000000Z',
                'address' => 'National Highway 27, Shreenathji Udyog Nagar, Darji Society, Navagadh',
                'formatted_address' => 'QJ85+CQP, NH 27, Shreenathji Udyog Nagar, Darji Society, Navagadh, Jetpur, Gujarat 360375, India',
                'locality' => 'Jetpur',
                'city' => 'Rajkot',
                'country' => 'India',
            ],
            [
                'latitude' => '21.7659165',
                'longitude' => '70.6101682',
                'location_time' => '2023-12-11T18:30:00.000000Z',
                'address' => 'National Highway 27, Shreenathji Udyog Nagar, Darji Society, Navagadh',
                'formatted_address' => 'QJ85+CQP, NH 27, Shreenathji Udyog Nagar, Darji Society, Navagadh, Jetpur, Gujarat 360375, India',
                'locality' => 'Jetpur',
                'city' => 'Rajkot',
                'country' => 'India',
            ],
            [
                'latitude' => '23.042872',
                'longitude' => '72.545418',
                'location_time' => '2023-12-23T18:30:00.000000Z',
                'address' => 'University Area',
                'formatted_address' => '2GVW+5CX, University Area, Ahmedabad, Gujarat 380009, India',
                'locality' => 'Ahmedabad',
                'city' => 'Ahmedabad',
                'country' => 'India',
            ],
            [
                'latitude' => '23.028095',
                'longitude' => '72.553447',
                'location_time' => '2023-12-23T18:30:00.000000Z',
                'address' => 'Vasundhra Colony, Gulbai Tekra',
                'formatted_address' => '9, Vasundhra Colony, Gulbai Tekra, Ahmedabad, Gujarat 380006, India',
                'locality' => 'Ahmedabad',
                'city' => 'Ahmedabad',
                'country' => 'India',
            ],
            [
                'latitude' => '23.041424',
                'longitude' => '72.577438',
                'location_time' => '2023-12-23T18:30:00.000000Z',
                'address' => 'Shah Colony, Kazipur Dariyapur',
                'formatted_address' => '2HRG+JWM, Shah Colony, Kazipur Dariyapur, Ahmedabad, Gujarat 380004, India',
                'locality' => 'Ahmedabad',
                'city' => 'Ahmedabad',
                'country' => 'India',
            ],
            [
                'latitude' => '23.044208',
                'longitude' => '72.580292',
                'location_time' => '2023-12-23T18:30:00.000000Z',
                'address' => 'Tavdipura, Shaktinagar Society, Kazipur Dariyapur',
                'formatted_address' => 'C/5 shubh labh Estate, Shaktinagar Society, Tavdipura, Kazipur Dariyapur, Ahmedabad, Gujarat 380004, India',
                'locality' => 'Ahmedabad',
                'city' => 'Ahmedabad',
                'country' => 'India',
            ],
            [
                'latitude' => 22.2986066,
                'longitude' => 73.1232061,
                'formatted_address' => 'Ravi park society, Siyed vasna, vadodara, gujarat',
                'address' => 'Ravi park society, Siyed vasna',
                'locality' => 'Vadodara',
                'city' => 'Vadodara',
                'country' => 'India',
            ],
            [
                'latitude' => 22.2960201,
                'longitude' => 73.1324528,
                'formatted_address' => 'Gotri, vadodara, gujarat',
                'locality' => 'Gotri',
                'city' => 'Vadodara',
                'country' => 'India',
            ],
            [
                'latitude' => 22.3224239,
                'longitude' => 73.1540479,
                'formatted_address' => 'Shubhanpura, vadodara, gujarat',
                'locality' => 'Shubhanpura',
                'city' => 'Vadodara',
                'country' => 'India',
            ],
            [
                'latitude' => 22.326402,
                'longitude' => 73.184584,
                'formatted_address' => 'Fatehgunj, vadodara, gujarat',
                'locality' => 'Fatehgunj',
                'city' => 'Vadodara',
                'country' => 'India',
            ],
            [
                'latitude' => 22.317550,
                'longitude' => 73.197056,
                'formatted_address' => 'Viththalnagar, karelibaugh, vadodara, gujarat',
                'address' => 'Viththalnagar, karelibaugh',
                'locality' => 'Karelibaugh',
                'city' => 'Vadodara',
                'country' => 'India',
            ],
            [
                'latitude' => 22.293389,
                'longitude' => 73.222432,
                'formatted_address' => 'Swami narayan flats, suryanagar, vadodara, gujarat',
                'address' => 'Swami narayan flats, suryanagar',
                'locality' => 'Suryanagar',
                'city' => 'Vadodara',
                'country' => 'India',
            ]
        ];
        foreach( $users as $user ){
            for($i = 0; $i < 5; $i++){
                $data = Arr::random( $latLong );
                data_set( $data, 'user_id', $user->id );
                data_set( $data, 'company_id', 1 );
                data_set( $data, 'location_time', now()->addDays( $faker->randomDigit( 1, 5 ) )->format('Y-m-d H:i:s') );
                data_set( $data, 'created_at', now() );
                data_set( $data, 'updated_at', now() );

                $memberLocation = new MemberLocation( $data );
                $memberLocation->save();
            }

        }
    }
}
