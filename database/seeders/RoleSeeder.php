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

        $permissions = Permission::all();
        $permissionsIds = $permissions->pluck('id');
        $users = User::with('defaultCompany')->typeCompany()->get();

        $roles = [
            [
                'role_name' => 'Admin',
                'permissions' => [
                    'Member List',
                    'Add Member',
                    'Update Member',
                    'Remove Member',
                    'Role List',
                    'Add Role',
                    'Update Role',
                    'Remove Role',
                    'Branch List',
                    'Add Branch',
                    'Update Branch',
                    'Remove Branch'
                ]
            ],
            [
                'role_name' => 'Property Manager',
                'permissions' => [
                    'Property List',
                    'View Property',
                    'Add Property',
                    'Update Property',
                    'Remove Property',
                    'Document List',
                ]
            ],
            [
                'role_name' => 'Lead Manager',
                'permissions' => [
                    'Lead List',
                    'View Lead',
                    'Add Lead',
                    'Update Lead',
                    'Can Comment',
                    'Remove Lead',
                ]
            ]
        ];
        foreach( $users as $item ){
            foreach( $roles as $data ){

                if( !is_null( $item->defaultCompany )){
                    $role = new Role();
                    $role->name = data_get( $data, 'role_name', $faker->text( 12 ));
                    $role->user_id = $item->id;
                    $role->company_id = $item->defaultCompany->id;
                    $role->guard_name = 'web';
                    $role->save();

                    $rolePermissions = data_get( $data, 'permissions');
                    if( !empty( $rolePermissions )){
                        $role->syncPermissions( $permissions->whereIn( 'name', $rolePermissions)->pluck('id') );

                    }else{
                        $role->syncPermissions( $permissionsIds->random( 5 ) );

                    }
                }
            }

        }
    }
}
