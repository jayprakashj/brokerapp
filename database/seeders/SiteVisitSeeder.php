<?php

namespace Database\Seeders;

use App\Models\CompanyBranch;
use App\Models\Project;
use App\Models\Property;
use App\Models\User;
use App\Models\Scopes\CompanyIdScope;
use App\Models\SiteVisit;
use App\Models\Task;
use App\Models\TaskStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SiteVisitSeeder extends Seeder
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

        $branches = CompanyBranch::withoutGlobalScope(CompanyIdScope::class)->get();
        $properties = Property::withoutGlobalScope(CompanyIdScope::class)->get();
        $projects = Project::withoutGlobalScope(CompanyIdScope::class)->get();
        $users = User::with('defaultCompany')->typeCompany()->get();
        $members = User::with('defaultCompany')->typeIndividual()->get();

        $latLong = [
            [
                'lat' => 22.2986066,
                'long' => 73.1232061,
                'address' => 'Ravi park society, Siyed vasna, vadodara, gujarat'
            ],
            [
                'lat' => 22.2960201,
                'long' => 73.1324528,
                'address' => 'Gotri, vadodara, gujarat'
            ],
            [
                'lat' => 22.3224239,
                'long' => 73.1540479,
                'address' => 'Shubhanpura, vadodara, gujarat'
            ],
            [
                'lat' => 22.326402,
                'long' => 73.184584,
                'address' => 'Fatehgunj, vadodara, gujarat'
            ],
            [
                'lat' => 22.317550,
                'long' => 73.197056,
                'address' => 'Viththalnagar, karelibaugh, vadodara, gujarat'
            ],
            [
                'lat' => 22.293389,
                'long' => 73.222432,
                'address' => 'Swami narayan flats, suryanagar, vadodara, gujarat'
            ]
        ];
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $latLng = Arr::random( $latLong );
            $obj = new SiteVisit();

            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->company_branch_id = $branches->random()->id;

            $obj->type = Arr::random( ['project', 'property'] );
            $obj->property_id = ( ($obj->type == 'property') ? $properties->random()->id : null ) ;
            $obj->project_id = ( ($obj->type == 'project') ? $projects->random()->id : null ) ;
            $obj->site_name = $faker->text( 7 );
            $obj->site_owner = $faker->text( 7 );
            $obj->visit_type = Arr::random( ['Direct Visit', 'Line Visit'] );
            $obj->time_in = now()->addDays( $faker->randomDigit( 10, 100 ) )->format('Y-m-d H:i:s');
            $obj->time_out = now()->addDays( $faker->randomDigit( 10, 100 ) )->format('Y-m-d H:i:s');
            $obj->comments = $faker->text( 16 );
            $obj->location = data_get( $latLng, 'address', $faker->text( 16 ) );
            $obj->latitude = data_get( $latLng, 'lat', $faker->latitude(22, 23) );
            $obj->longitude = data_get( $latLng, 'long', $faker->longitude( 73,74) );
            $obj->source_manager = $members->random()->id;
            $obj->closing_manager = $members->random()->id;
            $obj->assign_to = $members->random()->id;
            $obj->save();

        }
    }
}
