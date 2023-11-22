<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\ContactType;
use App\Models\CustomerType;
use App\Models\Scopes\CompanyIdScope;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ContactSeeder extends Seeder
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

        $contactTypes = ContactType::withoutGlobalScope(CompanyIdScope::class)->get();
        $customerTypes = CustomerType::withoutGlobalScope(CompanyIdScope::class)->get();
        $users = User::with('defaultCompany')->typeCompany()->get();
        $namePrfixes = array_keys( Contact::NAME_PREFIX_LIST );
        $contactNames = [
            'Ramesh Patel',
            'Kartik Shah',
            'Manisha Patel',
            'Krishna Bhatt',
            'Navin Shah',
            'Ravi Parmar',
            'Raveena Patel',
            'Kishan Parmar',
            'Kruti Patel',
            'Kritika Sinh',
            'Krupal Singh',
        ];

        $address = [
            'New alkapuri',
            'Bhayali Road',
            'opp Shivam Hospital, Nr Shell Petrol pump',
            'Nr Gotri Talav, Sevasi',
            'Yes Complex char rasta',
            'Shktivan society, Chakli Circle',
            'Ramvan Bunglows, OP Road',

        ];
        $locality = [
            'Gotri Talav',
            'Genda Circle',
            'Karelibaug',
            'VIP Road',
            'Bhayli Gotri Road',
            'Bhayli Road',
            'Gotri Road',
            'New Sama',
            'Sama Sport Complex',
            'Chaani',
            'Nizamppura',
        ];
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $obj = new Contact();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->name_prefix = Arr::random( $namePrfixes );
            $obj->name = Arr::random( $contactNames );
            $obj->country_code = 91;
            $obj->mobile = $faker->numberBetween( 1111111111, 9999999999);
            $obj->is_whatsapp_available = Arr::random( [0,1] );
            $obj->other_contact_country_code = 91;
            $obj->other_contact_no = $faker->numberBetween( 1111111111, 9999999999);
            $obj->email = Str::slug($faker->text( 12 ), '_' ) . '@mailinator.com';
            $obj->is_email_verified = Arr::random( [0,1] );
            $obj->gender = Arr::random( ['male', 'female', 'other'] );
            $obj->address = Arr::random( $address );
            $obj->city = 'Vadodara';
            $obj->locality = Arr::random( $locality );
            $obj->pincode = $faker->text( 6 );
            $obj->comment = $faker->text( 10 );
            $obj->company_name = $faker->text( 6 );
            $obj->designation = $faker->text( 6 );
            $obj->birth_date = now()->subDays( $faker->randomDigit() )->format('Y-m-d');
            $obj->enable_whatsapp_wishes = Arr::random( [0,1] );
            $obj->enable_sms_wishes = Arr::random( [0,1] );
            $obj->enable_email_wishes = Arr::random( [0,1] );
            $obj->customer_type_id = $customerTypes->random()->id;
            $obj->contact_type_id = $contactTypes->random()->id;
            $obj->save();

        }
    }
}
