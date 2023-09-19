<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Scopes\CompanyIdScope;
use App\Models\Task;
use App\Models\TaskStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
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

        $statuses = TaskStatus::withoutGlobalScope(CompanyIdScope::class)->get();
        $users = User::with('defaultCompany')->typeCompany()->get();
        $members = User::with('defaultCompany')->typeIndividual()->get();
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $obj = new Task();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->title = $faker->text( 7 );
            $obj->status = $statuses->random()->name;
            $obj->description = $faker->text( 16 );
            $obj->remark = $faker->text( 16 );
            $obj->scheduled_date = now()->addDays($faker->numberBetween( 20, 100 ))->format('Y-m-d');
            $obj->assign_to = $members->random()->id;
            $obj->save();

        }
    }
}
