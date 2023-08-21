<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\CompanyBranch;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
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

        $users = User::with('defaultCompany')->get();
        foreach( $users as $item ){
            for($i = 0; $i < 2; $i++){
                $branch = new CompanyBranch();
                $branch->user_id = $item->id;
                $branch->created_by = $item->id;
                $branch->updated_by = $item->id;
                $branch->company_id = $item->defaultCompany->id;
                $branch->name = $faker->text( 12 );
                $branch->email = Str::slug($faker->text( 12 ), '_' ) . '@mailinator.com';
                $branch->mobile = $faker->numberBetween( 1111111111, 9999999999);
                $branch->address = $faker->text( 22 );
                $branch->city = $faker->text( 10 );
                $branch->state = $faker->text( 6 );
                $branch->save();

            }
        }
    }
}
