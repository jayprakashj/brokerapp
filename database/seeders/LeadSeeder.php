<?php

namespace Database\Seeders;

use App\Models\CompanyBranch;
use App\Models\Contact;
use App\Models\User;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Project;
use App\Models\Property;
use App\Models\PropertySubTypeList;
use App\Models\Scopes\CompanyIdScope;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Schema::disableForeignKeyConstraints();
        Lead::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = app( Faker::class );

        $leadSource = LeadSource::withoutGlobalScope(CompanyIdScope::class)->get();
        $leadStatus = LeadStatus::withoutGlobalScope(CompanyIdScope::class)->get();
        $companyBranches = CompanyBranch::withoutGlobalScope(CompanyIdScope::class)->get();
        $properties = Property::withoutGlobalScope(CompanyIdScope::class)->get();
        $projects = Project::withoutGlobalScope(CompanyIdScope::class)->get();
        $contacts = Contact::withoutGlobalScope(CompanyIdScope::class)->get();
        $users = User::with('defaultCompany')->typeCompany()->get();
        $propertyTypes = PropertySubTypeList::withoutGlobalScope(CompanyIdScope::class)->get();

        $titles = [
            'Looking for 2 BHK flat',
            '3 Bhk Rent Property',
            'Rental for 2 BHK Flat',
            'Sell 3 BHK bunglow',
            'Rent on office',
            '3 BHK Bunglow rent',
            'Looking for tenant for my 1 bhk flat',
            'Resell my property of 2 bhk duplex'
        ];
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $contactObj = $contacts->random();
            $obj = new Lead();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->title = Arr::random( $titles );
            $obj->contact_id = $contactObj->id;
            $obj->company_branch_id = $companyBranches->random()->id;
            $obj->customer_name = $contactObj->name;
            $obj->customer_mobile = $contactObj->mobile;
            $obj->customer_email = $contactObj->email;
            $obj->customer_city = $contactObj->city;
            $obj->remark = $faker->text( 10 );
            $obj->keywords = $faker->text( 10 );
            $obj->interest_in = $faker->text( 6 );
            $obj->purpose = $faker->text( 10 );
            $obj->min_budget = $faker->numberBetween( 10000, 22000);
            $obj->max_budget = $faker->numberBetween( $obj->min_budget, 500000);
            $obj->assigned_to = $users->random()->id;
            $obj->is_confidential = $faker->boolean();
            $obj->is_private = $faker->boolean();
            $obj->is_protected = $faker->boolean();
            $obj->lead_source = $leadSource->random()->name;
            $obj->lead_status = $leadStatus->random()->name;
            $obj->followup_date = $i > 1 ? now()->addDay( $faker->randomDigit() )->format('Y-m-d') : null;
            $obj->assigned_date = today();
            $obj->enquiry_type = Arr::random( array_values( Lead::ENQUIRY_TYPES ));
            $obj->property_type = [$propertyTypes->random()->name];
            $obj->save();

            $obj->properties()->sync( $properties->random( 3 )->pluck('id') );
            $obj->projects()->sync( $projects->random( 3 )->pluck('id') );

            $leadComment = new LeadComment();
            $leadComment->user_id = $item->id;
            $leadComment->created_by = $item->id;
            $leadComment->updated_by = $item->id;
            $leadComment->company_id = $item->defaultCompany->id;
            $leadComment->lead_id = $obj->id;
            $leadComment->comment = 'New Lead Generated';
            $leadComment->lead_status = $obj->lead_status;
            $leadComment->followup_date = $obj->followup_date;
            $leadComment->save();

        }
    }
}
