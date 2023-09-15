<?php

namespace Database\Seeders;

use App\Models\CompanyBranch;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\PropertyFacingList;
use App\Models\PropertyFurnishList;
use App\Models\PropertyObligationList;
use App\Models\PropertyTransactionList;
use App\Models\PropertyTypeList;
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
        $propertyTypes = PropertyTypeList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyTransactions = PropertyTransactionList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyFurnishes = PropertyFurnishList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyFacings = PropertyFacingList::withoutGlobalScope(CompanyIdScope::class)->get();
        $propertyObligation = PropertyObligationList::withoutGlobalScope(CompanyIdScope::class)->get();
        
        $users = User::with('defaultCompany')->typeCompany()->get();
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $paragraphs = $faker->paragraphs(rand(2, 6));
            $content = '<b>' . $faker->text( 10 ) . '</b>';
            foreach( $paragraphs as $content){
                $content .= '<p>' . $content . '</p>';

            }
            $obj = new Property();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            
            $obj->name = $faker->text( 10 );
            $obj->company_branch_id = $companyBranches->random()->id;
            
            $obj->assign_to = $users->random()->id;
            $obj->property_type = $propertyTypes->random()->name;
            $obj->property_transaction = $propertyTransactions->random()->name;
            $obj->property_furnishing = $propertyFurnishes->random()->name;
            $obj->property_facing = $propertyFacings->random()->name;
            $obj->property_obligation = $propertyObligation->random()->name;
            
            $obj->building_name = $faker->text( 10 );
            $obj->unit_no = $faker->text( 6 );
            $obj->is_verified = $faker->boolean();
            $obj->is_document_verified = $faker->boolean();
            $obj->address = $faker->text( 10 );
            $obj->city = $faker->text( 6 );
            $obj->locality = $faker->text( 6 );
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
            $obj->availability = Arr::random(['Yes', 'No']);
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
