<?php

namespace Database\Seeders;

use App\Models\CompanyBranch;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Project;
use App\Models\Property;
use App\Models\Scopes\CompanyIdScope;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
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

        $leadSource = LeadSource::withoutGlobalScope(CompanyIdScope::class)->get();
        $leadStatus = LeadStatus::withoutGlobalScope(CompanyIdScope::class)->get();
        $companyBranches = CompanyBranch::withoutGlobalScope(CompanyIdScope::class)->get();
        $properties = Property::withoutGlobalScope(CompanyIdScope::class)->get();
        $projects = Project::withoutGlobalScope(CompanyIdScope::class)->get();
        $contacts = Contact::withoutGlobalScope(CompanyIdScope::class)->get();
        $users = User::with('defaultCompany')->typeCompany()->get();
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $contactObj = $contacts->random();
            $obj = new Lead();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->property_id = $properties->random()->id;
            $obj->project_id = $projects->random()->id;
            $obj->title = $faker->text( 10 );
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
            $obj->budget = $faker->numberBetween( 10000, 99999);;
            $obj->assigned_to = $users->random()->id;
            $obj->is_confidential = $faker->boolean();
            $obj->is_private = $faker->boolean();
            $obj->is_protected = $faker->boolean();
            $obj->lead_source = $leadSource->random()->name;
            $obj->lead_status = $leadStatus->random()->name;
            $obj->followup_date = now()->addDay( $faker->randomDigit() )->format('Y-m-d');
            $obj->assigned_date = today();
            $obj->save();

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
