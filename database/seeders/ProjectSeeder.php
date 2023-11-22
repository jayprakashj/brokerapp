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
        $projectTypes = array_keys( Project::PROJECT_TYPES );
        $projectsData = [
            [
                'title' => 'Fortune Imperia II',
                'devloper_name' => 'Shreeji Infra',
                'building' => 'TP-1',
                'owner_name' => 'Shreeji Infra',
                'address' => 'Opp. Atha Shree Luxuria, Near Nilamber Circle, Vasant Vihar',
                'landmark' => 'Bhayali',
                'locality' => 'Bhayali',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Shyamal Park',
                'devloper_name' => 'Shree Ganesh Infra Homes',
                'building' => 'Shyamal Park',
                'owner_name' => 'Shree Ganesh Infra Homes',
                'address' => 'Vasna Bhayli Road',
                'landmark' => 'Bhayli Road',
                'locality' => 'Bhayli',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Darshanam Splendora 3',
                'devloper_name' => 'Darshanam Group',
                'building' => 'Darshanam Splendora',
                'owner_name' => 'Darshanam Group',
                'address' => 'Opp. Auro Crystal, Near Suryadarshan Township',
                'landmark' => 'Manjalpur',
                'locality' => 'Manjalpur',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Param Sapphire',
                'devloper_name' => 'Param Group',
                'building' => 'Param Sapphire',
                'owner_name' => 'Param Group',
                'address' => 'Param Sapphire, Near Harni Lake Garden Harni Police Station Road',
                'landmark' => 'Harni',
                'locality' => 'Harni',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Shangri La Imperial',
                'devloper_name' => 'Kuber Royal',
                'building' => 'Shangri La Imperial',
                'owner_name' => 'Kuber Royal',
                'address' => 'Near by Raj International Hotel Ajwa - Nimeta, Main Road',
                'landmark' => 'Ajwa Road',
                'locality' => 'Ajwa Road',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Courtyard Regalia',
                'devloper_name' => 'Courtyard Group',
                'building' => 'Courtyard Regalia',
                'owner_name' => 'Courtyard Group',
                'address' => 'Courtyard Regalia, Opp. Madrid County, 24 Mtr Bhayli Station Road, Bhayli Tp-5',
                'landmark' => 'Bhayli',
                'locality' => 'Bhayli',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Vihav Parvarish',
                'devloper_name' => 'Vihav Group',
                'building' => 'Vihav Parvarish',
                'owner_name' => 'Vihav Group',
                'address' => 'Near Sevasi',
                'landmark' => 'Sevasi',
                'locality' => 'Sevasi',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Ultima Crest',
                'devloper_name' => 'Kamlesh Gandhi Projects',
                'building' => 'Ultima Crest',
                'owner_name' => 'Kamlesh Gandhi Projects',
                'address' => 'Dabhoi-Waghodia Ring Road',
                'landmark' => 'Waghodia Road',
                'locality' => 'Waghodia Road',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Aarna 48',
                'devloper_name' => 'Aarna Buildtech',
                'building' => 'Aarna 48',
                'owner_name' => 'Aarna Buildtech',
                'address' => 'Bhayli, Vadodara',
                'landmark' => 'Bhayli',
                'locality' => 'Bhayli',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Aamrapali Luxuria',
                'devloper_name' => 'Aamrapali Developers',
                'building' => 'Aamrapali Luxuria',
                'owner_name' => 'Aamrapali Developers',
                'address' => 'Opposite Ruchi Boulevard, Near Ramkrishna Paramhans Hospital',
                'landmark' => 'Kalali',
                'locality' => 'Kalali',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Survi Pristine',
                'devloper_name' => 'Survi Infraspace LLP',
                'building' => 'Survi Pristine',
                'owner_name' => 'Survi Infraspace LLP',
                'address' => 'Opp Banker\'s Heart Hospital, Tulsidham-Jupiter Road',
                'landmark' => 'ManjalPur',
                'locality' => 'ManjalPur',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Samruddhi Hayosha',
                'devloper_name' => 'Samruddhi Builders',
                'building' => 'Samruddhi Hayosha',
                'owner_name' => 'Samruddhi Builders',
                'address' => 'Nr. Vaishnav Park Society, Opp. M M Vora Showroom, Soma Talav Crossing',
                'landmark' => 'Dabhoi Road',
                'locality' => 'Dabhoi Road',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Uma Residences',
                'devloper_name' => 'Kabel Buildcon',
                'building' => 'Uma Residences',
                'owner_name' => 'Kabel Buildcon',
                'address' => 'VASNA BHAYLI TP1,',
                'landmark' => 'VASNA BHAYLI TP1',
                'locality' => 'Bhayli',
                'city' => 'Vadodara',
            ],
            [
                'title' => 'Lilleria Oakwoods',
                'devloper_name' => 'Lilleria Group',
                'building' => 'Lilleria Oakwoods',
                'owner_name' => 'Lilleria Group',
                'address' => 'Lilleria Oakwoods,Next to Billabong School & Park Paradise, New Manjalpur-Vadsar Ring Road',
                'landmark' => 'Vadsar Ring Road',
                'locality' => 'Vadsar',
                'city' => 'Vadodara',
            ],
        ];
        $projectsName = [
            'The Green Parmeshwar',
            'Empire Skypark',
            'Swara Skyline',
            'The Q',
            'Viaan Skyrise',
            'Samanvay Anantam',
            'Anandam Greens',
            'Param Sapphire',
            'Sangini Aura',
            'Pramukh Amaya',
            'Siddhi Vinayak Elements'
        ];
        $localities = [
            'Jagatpur',
            'Science City',
            'Akota',
            'Umeta',
            'Harni',
            'Pal',
            'Palanpur',
            'Jahangirabad',
        ];
        $cities = [
            'Ahmedabad',
            'Surat',
            'Vadodara',
            'Gandhinagar',
            'Bharuch',
        ];
        for($i = 0; $i < 18; $i++){

            $item = $users->random();

            $totalProjects = count( $projectsData );
            $dataIndex = rand( 0, $totalProjects );

            $pData = data_get( $projectsData, $dataIndex, 0 );

            if( $totalProjects > 0 ){
                unset( $projectsData[ $dataIndex ] );
            }

            $obj = new Project();

            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->title = data_get( $pData, 'title', Arr::Random( $projectsName ) );
            $obj->project_type = Arr::random( $projectTypes );
            $obj->rera_reg_no = substr( str_shuffle('ABCDEFGHIJKL1234567890'),0,8 );;
            $obj->project_no = substr( str_shuffle('ABCDEFGHIJKL1234567890MNOPQRSTUVWXYZ'),0,8 );
            $obj->launch_date = now()->subDays( $faker->numberBetween( 30, 900) )->format('Y-m-d');
            $obj->completion_date = now()->addDays( $faker->numberBetween( 30, 900) )->format('Y-m-d');
            $obj->company_branch_id = $companyBranches->random()->id;
            $obj->project_area = $faker->text( 10 );
            $obj->developer_name = data_get( $pData, 'developer_name', $faker->text( 10 ) );
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
            $obj->landmark = data_get( $pData, 'landmark', $faker->text( 6 ) );
            $obj->city = data_get( $pData, 'city', Arr::Random( $cities ));
            $obj->locality = data_get( $pData, 'locality', Arr::Random( $localities ) );
            $obj->building = data_get( $pData, 'building', $faker->text( 6 ) );
            $obj->address = data_get( $pData, 'address', $faker->text( 16 ) );
            $obj->amenities = $faker->text( 6 );
            $obj->owner_name = data_get( $pData, 'owner_name', $faker->text( 6 ));
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
