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
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $obj = new Contact();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->name = $faker->text( 10 );
            $obj->mobile = $faker->numberBetween( 1111111111, 9999999999);
            $obj->email = Str::slug($faker->text( 12 ), '_' ) . '@mailinator.com';
            $obj->gender = Arr::random( ['male', 'female', 'other'] );
            $obj->address = $faker->text( 10 );
            $obj->city = $faker->text( 10 );
            $obj->locality = $faker->text( 10 );
            $obj->pincode = $faker->text( 10 );
            $obj->comment = $faker->text( 10 );
            $obj->customer_type_id = $contactTypes->random()->id;
            $obj->contact_type_id = $customerTypes->random()->id;
            $obj->save();

        }
    }
}
