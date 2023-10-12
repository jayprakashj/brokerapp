<?php

namespace Database\Seeders;

use App\Models\CompanyBranch;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\PropertyFacingList;
use App\Models\PropertyFurnishList;
use App\Models\PropertyObligationList;
use App\Models\PropertySubTypeList;
use App\Models\PropertyTransactionList;
use App\Models\Scopes\CompanyIdScope;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PropertySeeder extends Seeder
{

    public function __construct()
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = app( Faker::class );

        $companyBranches = CompanyBranch::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyTypes = PropertySubTypeList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyTransactions = PropertyTransactionList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyFurnishes = PropertyFurnishList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyFacings = PropertyFacingList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyObligation = PropertyObligationList::withoutGlobalScope(CompanyIdScope::class)->get();
        $availabilities = array_values( Property::AVAILABILITIES_LIST );

        $propertyData = [
            [
                'title' => '2 BHK 1050 Sq-ft Flat',
                'building_name' => 'Pratham Bluets',
                'unit_no' => '001',
                'property_type' => 'Flats',
                'property_transaction' => 'Sell',
                'address' => 'New Alkapuri',
                'locality' => 'New Alkapuri',
                'city' => 'Vadodara',
                'price' => '3500000',
                'owner_name' => 'Pratham Enterprises',
            ],
            [
                'title' => '2 BHK 750 Sq-ft Flat For Sale',
                'building_name' => 'Avadh Skyline',
                'unit_no' => '005',
                'property_type' => 'Flats',
                'property_transaction' => 'Sell',
                'address' => 'Tarsali',
                'locality' => 'Tarsali',
                'city' => 'Vadodara',
                'price' => '4500000',
                'owner_name' => 'Avadh Developers',
            ],
            [
                'title' => '2 BHK For Sale in SHIVALAYA TENAMENTS',
                'building_name' => 'SHIVALAYA TENAMENTS',
                'unit_no' => '001',
                'property_type' => 'Bunglows',
                'property_transaction' => 'Resell',
                'address' => 'MANEJA',
                'locality' => 'MANEJA',
                'city' => 'Vadodara',
                'price' => '6200000',
                'owner_name' => 'Rameshbhai Makwana',
            ],
            [
                'title' => '2 BHK Owner Residential House',
                'building_name' => 'Sahyog Soceity',
                'unit_no' => 'C 82.',
                'property_type' => 'Duplex',
                'property_transaction' => 'Resell',
                'address' => 'Vadodara',
                'locality' => 'Vadodara',
                'city' => 'Vadodara',
                'price' => '13200000',
                'owner_name' => 'Satishbhai',
            ],
            [
                'title' => '2 BHK 1280 Sq-ft For Rent ',
                'building_name' => 'Siddharth Bungalows',
                'unit_no' => 'B328',
                'property_type' => 'Duplex',
                'property_transaction' => 'Rental',
                'address' => 'B328, Siddharth Bunglow, Sama Savli road, Besides Rhythm Hospital',
                'locality' => 'New Sama',
                'city' => 'Vadodara',
                'price' => '9400',
                'owner_name' => 'Manishbhai',
            ],
            [
                'title' => '2 BHK Residential House',
                'building_name' => 'Jalaram Society',
                'unit_no' => '001',
                'property_type' => 'Duplex',
                'property_transaction' => 'Rental',
                'address' => 'Near jalaram temple sama., Sama Road',
                'locality' => 'Sama Road',
                'city' => 'Vadodara',
                'price' => '11400',
                'owner_name' => 'Kaushikbhai',
            ],
            [
                'title' => '2 BHK Residential House',
                'building_name' => 'Vaikunth Bunglows',
                'unit_no' => 'L 27',
                'property_type' => 'Villa',
                'property_transaction' => 'Rental',
                'address' => 'Opp Pranayam Hospital, New VIP road, Karelibaug',
                'locality' => 'Karelibaug',
                'city' => 'Vadodara',
                'price' => '11400',
                'owner_name' => 'Nehal Shah',
            ],
            [
                'title' => '2 BHK Residential House',
                'building_name' => 'Vaikunth Bunglows',
                'unit_no' => 'L 27',
                'property_type' => 'Villa',
                'property_transaction' => 'Rental',
                'address' => 'Opp Pranayam Hospital, New VIP road, Karelibaug',
                'locality' => 'Karelibaug',
                'city' => 'Vadodara',
                'price' => '11400',
                'owner_name' => 'Nehal Shah',
            ],
            [
                'title' => '1 BHK 1000 Sq-ft For Rent in Prime Vatika',
                'building_name' => 'Prime Vatika',
                'unit_no' => 'A-001',
                'property_type' => 'Villa',
                'property_transaction' => 'Rental',
                'address' => 'Opp SUMANDEEP VIDYAPEETH,Near Parul University',
                'locality' => 'Sayajipura',
                'city' => 'Vadodara',
                'price' => '11400',
                'owner_name' => 'Govindkumar Sinh',
            ],
            [
                'title' => '3 BHK Flat 1755 Sq-ft For Rent',
                'building_name' => 'Samsara Luxury Apartment',
                'unit_no' => 'K-906',
                'property_type' => 'Flats',
                'property_transaction' => 'Rental',
                'address' => 'Samsara Luxury Apartment,Nizampura',
                'locality' => 'Nizampura',
                'city' => 'Vadodara',
                'price' => '27500',
                'owner_name' => 'Parth Patel',
            ],

            [
                'title' => '3 BHK Flat 1600 Sq-ft For Rent',
                'building_name' => 'Crystal Arc',
                'unit_no' => 'A-009',
                'property_type' => 'Flats',
                'property_transaction' => 'Rental',
                'address' => 'Vasna Bhayli Main Road',
                'locality' => 'Vasna Bhayli Main Road',
                'city' => 'Vadodara',
                'price' => '27500',
                'owner_name' => 'Kirti Patel',
            ],

            [
                'title' => '3 BHK Flat 1100 Sq-ft For Rent',
                'building_name' => 'Samanvay Westfields',
                'unit_no' => 'A-410',
                'property_type' => 'Flats',
                'property_transaction' => 'Rental',
                'address' => 'Vasna Bhayli Main Road',
                'locality' => 'Vasna Bhayli Main Road',
                'city' => 'Vadodara',
                'price' => '21500',
                'owner_name' => 'Nandita Patel',
            ],

            [
                'title' => 'Commercial Shop For Sale',
                'building_name' => 'Pratham Plaza',
                'unit_no' => '001',
                'property_type' => 'Shops',
                'property_transaction' => 'Sell',
                'address' => 'Pratham Plaza, Akota',
                'locality' => 'Akota',
                'city' => 'Vadodara',
                'price' => '3200000',
                'owner_name' => 'Pratham Developers',
            ],

            [
                'title' => 'Commercial Shop For Sale',
                'building_name' => 'Labh Icon',
                'unit_no' => '006',
                'property_type' => 'Shops',
                'property_transaction' => 'Resell',
                'address' => 'Near Bansal Mall, Nilamber Circle, 30 Mtr Gotri Vasna Road',
                'locality' => 'Gotri',
                'city' => 'Vadodara',
                'price' => '4000000',
                'owner_name' => 'Nileshbhai Bhatt',
            ],

            [
                'title' => 'Commercial Shop For Sale',
                'building_name' => 'Labh Icon',
                'unit_no' => '006',
                'property_type' => 'Shops',
                'property_transaction' => 'Resell',
                'address' => 'Near Bansal Mall, Nilamber Circle, 30 Mtr Gotri Vasna Road',
                'locality' => 'Gotri',
                'city' => 'Vadodara',
                'price' => '4000000',
                'owner_name' => 'Nileshbhai Bhatt',
            ],

        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        for($i = 0; $i < 20; $i++){
            $item = $users->random();
            $paragraphs = $faker->paragraphs(rand(2, 6));
            $content = '<b>' . $faker->text( 10 ) . '</b>';
            foreach( $paragraphs as $content){
                $content .= '<p>' . $content . '</p>';

            }
            $totalProps = count( $propertyData );
            $dataIndex = rand( 0, $totalProps );

            $pData = data_get( $propertyData, $dataIndex, 0 );

            if( $totalProps > 0 ){
                unset( $propertyData[ $dataIndex ] );
            }

            $obj = new Property();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $users->random()->id;
            $obj->company_id = $item->defaultCompany->id;

            $obj->name = data_get( $pData, 'title', $faker->text( 10 ));
            $obj->company_branch_id = $companyBranches->random()->id;

            $obj->assign_to = $users->random()->id;
            $obj->property_type = data_get( $pData, 'property_type', $propertyTypes->random()->name);
            $obj->property_transaction = data_get( $pData, 'property_transaction', $propertyTransactions->random()->name );
            $obj->property_furnishing = $propertyFurnishes->random()->name;
            $obj->property_facing = $propertyFacings->random()->name;
            $obj->property_obligation = $propertyObligation->random()->name;

            $obj->building_name = data_get( $pData, 'building_name', $faker->text( 10 ) );
            $obj->unit_no = data_get( $pData, 'unit_no', $faker->text( 6 ) );
            $obj->is_verified = $faker->boolean();
            $obj->is_document_verified = $faker->boolean();
            $obj->address = data_get( $pData, 'address', $faker->text( 10 ) );
            $obj->city = data_get( $pData, 'city', $faker->text( 6 ));
            $obj->locality = data_get( $pData, 'locality', $faker->text( 6 ));
            $obj->description = $faker->text( 10 );
            $obj->remark = $faker->text( 10 );
            $obj->internal_note = $faker->text( 10 );
            $obj->unique_feature = $faker->text( 10 );
            $obj->suitable_for = $faker->text( 6 );
            $obj->bedrooms = $faker->randomDigit();
            $obj->master_bedrooms = $faker->randomDigit();
            $obj->guest_room = $faker->randomDigit();
            $obj->child_room = $faker->randomDigit();
            $obj->other_room = $faker->randomDigit();
            $obj->bathrooms = $faker->randomDigit();
            $obj->common_bathrooms = $faker->randomDigit();
            $obj->ensult_bathrooms = $faker->randomDigit();
            $obj->sellable_area = $faker->text( 10 );
            $obj->builtup_area = $faker->text( 10 );
            $obj->carpet_area = $faker->text( 10 );
            $obj->plot_area = $faker->text( 10 );
            $obj->terrace_area = $faker->text( 10 );
            $obj->area_range = $faker->text( 10 );
            $obj->price = $faker->numberBetween( 10000, 99999);
            $obj->negotiable_amount = $faker->numberBetween( 10000, 99999);
            $obj->security_deposit = $faker->numberBetween( 10000, 99999);
            $obj->property_floor = $faker->randomDigit();
            $obj->total_floor = $faker->randomDigit();
            $obj->lease_period = $faker->text( 10 );
            $obj->lease_expiry_date = now()->format('Y-m-d');
            $obj->availability = Arr::random($availabilities);
            $obj->ownership = $faker->randomDigit();
            $obj->no_of_parking = $faker->randomDigit();
            $obj->no_of_lift = $faker->randomDigit();
            $obj->age_of_property = $faker->text( 10 );
            $obj->workstation = $faker->text( 10 );
            $obj->conference_room = Arr::random(['Yes', 'No']);
            $obj->reception = Arr::random(['Yes', 'No']);
            $obj->walk_through_link = null;
            $obj->amenities = $faker->text( 10 );
            $obj->owner_name = $faker->text( 6 );
            $obj->owner_email = Str::slug($faker->text( 12 ), '_' ) . '@mailinator.com';
            $obj->owner_phone = $faker->numberBetween( 1111111111, 9999999999);
            $obj->refer_by_name = $faker->text( 6 );
            $obj->refer_by_email = Str::slug($faker->text( 12 ), '_' ) . '@mailinator.com';
            $obj->refer_by_phone = $faker->numberBetween( 1111111111, 9999999999);
            $obj->assign_date = today();

            $obj->save();

        }
    }
}
