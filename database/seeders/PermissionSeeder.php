<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            'name' => 'User List',
            'group_name' => 'User',
        ]);
        Permission::create([
            'name' => 'Add User',
            'group_name' => 'User',
        ]);
        Permission::create([
            'name' => 'Remove User',
            'group_name' => 'User',
        ]);

        $role = Role::create(['name' => 'company-admin', 'company_id' => null]);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::whereGroupName('Company')->get());

        $role = Role::create(['name' => 'user Management']);
        $role->givePermissionTo(Permission::whereGroupName('User')->get());

        User::all()->each( function( $item ){
            $item->assignRole('company-admin');
        });
    }
}
