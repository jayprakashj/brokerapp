<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectPlan;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\ProjectTower;
use App\Models\CompanyBranch;
use App\Models\ProjectCharge;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Support\Facades\Schema;

class ProjectSeeder extends Seeder
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
        Schema::disableForeignKeyConstraints();
        Project::truncate();
        ProjectTower::truncate();
        ProjectPlan::truncate();
        ProjectCharge::truncate();
        Schema::enableForeignKeyConstraints();

        $faker = app( Faker::class );

        $companyBranches = CompanyBranch::withoutGlobalScope(CompanyIdScope::class)->get();
        $users = User::with('defaultCompany')->typeCompany()->get();
        for($i = 0; $i < 8; $i++){

            $item = $users->random();

            $obj = new Project();

            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->title = $faker->text( 10 );
            $obj->rera_reg_no = $faker->text( 10 );
            $obj->project_no = $faker->text( 10 );
            $obj->launch_date = now()->subDays( $faker->numberBetween( 30, 900) )->format('Y-m-d');
            $obj->completion_date = now()->addDays( $faker->numberBetween( 30, 900) )->format('Y-m-d');
            $obj->company_branch_id = $companyBranches->random()->id;
            $obj->project_area = $faker->text( 10 );
            $obj->developer_name = $faker->text( 10 );
            $obj->approved_by = $faker->text( 10 );
            $obj->open_space = $faker->text( 10 );
            $obj->total_unit = $faker->numberBetween( 10, 50 );
            $obj->availability = Arr::random( ['Yes', 'No']);
            $obj->availability_date = now()->addDays( $faker->numberBetween( 30, 900) )->format('Y-m-d');
            $obj->commencement_certificate = Arr::random( ['Yes', 'No']);
            $obj->occupancy_certificate = Arr::random( ['Yes', 'No']);
            $obj->specification = implode("\n", $faker->paragraphs( 5 ));
            $obj->description = implode("\n", $faker->paragraphs( 5 ));
            $obj->remark = $faker->text( 20 );
            $obj->landmark = $faker->text( 6 );
            $obj->city = $faker->text( 6 );
            $obj->locality = $faker->text( 6 );
            $obj->building = $faker->text( 6 );
            $obj->address = $faker->text( 16 );
            $obj->amenities = $faker->text( 6 );
            $obj->owner_name = $faker->text( 6 );
            $obj->owner_email = Str::slug($faker->text( 12 ), '_' ) . '@mailinator.com';
            $obj->owner_phone = $faker->numberBetween( 1111111111, 9999999999);
            $obj->assign_to = $users->random()->id;
            $obj->assign_date = today();
            $obj->save();

            for( $j = 0; $j < 2; $j++ ){

                $projectTower = new ProjectTower();
                $projectTower->user_id = $item->id;
                $projectTower->created_by = $item->id;
                $projectTower->updated_by = $item->id;
                $projectTower->company_id = $item->defaultCompany->id;
                $projectTower->project_id = $obj->id;
                $projectTower->tower_name = $faker->text( 10 );
                $projectTower->completion_date = now()->addDays( $faker->numberBetween( 30, 900) )->format('Y-m-d');
                $projectTower->save();

                $projectPlan = new ProjectPlan();
                $projectPlan->user_id = $item->id;
                $projectPlan->created_by = $item->id;
                $projectPlan->updated_by = $item->id;
                $projectPlan->company_id = $item->defaultCompany->id;
                $projectPlan->project_id = $obj->id;
                $projectPlan->tower = $faker->text( 10 );
                $projectPlan->type = $faker->text( 6 );
                $projectPlan->bhk = $faker->randomDigit();
                $projectPlan->area = $faker->text( 10 );
                $projectPlan->price = $faker->numberBetween( 1000000, 9000000);
                $projectPlan->basic_price = $faker->numberBetween( 1000000, 9000000);
                $projectPlan->save();

                $projectCharge = new ProjectCharge();
                $projectCharge->user_id = $item->id;
                $projectCharge->created_by = $item->id;
                $projectCharge->updated_by = $item->id;
                $projectCharge->company_id = $item->defaultCompany->id;
                $projectCharge->project_id = $obj->id;
                $projectCharge->charges = $faker->text( 10 );
                $projectCharge->description = $faker->text( 10 );
                $projectCharge->price = $faker->numberBetween( 1000000, 9000000);;
                $projectCharge->escalation_from = $faker->text( 10 );
                $projectCharge->save();
            }


        }
    }
}
