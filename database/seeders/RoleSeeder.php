<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Database\UserClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
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

        $permissions = Permission::all()->pluck('id');
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            for( $i = 0 ; $i < 5; $i++ ){
                if( !is_null( $item->defaultCompany )){
                    $role = new Role();
                    $role->name = $faker->text( 12 );
                    $role->user_id = $item->id;
                    $role->company_id = $item->defaultCompany->id;
                    $role->guard_name = 'web';
                    $role->save();

                    $role->syncPermissions( $permissions->random( 5 ) );
                }



            }
        }
    }
}
