<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Database\UserClass;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Role::truncate();
        Schema::disableForeignKeyConstraints();

        Permission::create([
            'name' => 'Create Company',
            'group_name' => 'Company',
        ]);
        Permission::create([
            'name' => 'Company List',
            'group_name' => 'Company',
        ]);
        Permission::create([
            'name' => 'Company Change Status',
            'group_name' => 'Company',
        ]);
        Permission::create([
            'name' => 'Company Update',
            'group_name' => 'Company',
        ]);

        Permission::create([
            'name' => 'Member List',
            'group_name' => 'Member',
        ]);
        Permission::create([
            'name' => 'Add Member',
            'group_name' => 'Member',
        ]);
        Permission::create([
            'name' => 'Update Member',
            'group_name' => 'Member',
        ]);
        Permission::create([
            'name' => 'Remove Member',
            'group_name' => 'Member',
        ]);

        Permission::create([
            'name' => 'Role List',
            'group_name' => 'Role',
        ]);
        Permission::create([
            'name' => 'Add Role',
            'group_name' => 'Role',
        ]);
        Permission::create([
            'name' => 'Update Role',
            'group_name' => 'Role',
        ]);
        Permission::create([
            'name' => 'Remove Role',
            'group_name' => 'Role',
        ]);

        Permission::create([
            'name' => 'Branch List',
            'group_name' => 'Branch',
        ]);
        Permission::create([
            'name' => 'Add Branch',
            'group_name' => 'Branch',
        ]);
        Permission::create([
            'name' => 'Update Branch',
            'group_name' => 'Branch',
        ]);
        Permission::create([
            'name' => 'Remove Branch',
            'group_name' => 'Branch',
        ]);

        $role = Role::create(['name' => 'company-admin', 'company_id' => null]);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'user-admin']);
        $role->givePermissionTo(Permission::whereGroupName('Company')->get());

        $role = Role::create(['name' => 'user Management']);
        $role->givePermissionTo(Permission::whereGroupName('User')->get());

        // User::all()->each( function( $item ){
        //     $item->assignRole('company-admin');
        // });
    }
}
