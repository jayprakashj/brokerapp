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
            'name' => 'Company Setting',
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

        Permission::create([
            'name' => 'Contact List',
            'group_name' => 'Contact',
        ]);
        Permission::create([
            'name' => 'View Contact',
            'group_name' => 'Contact',
        ]);
        Permission::create([
            'name' => 'Add Contact',
            'group_name' => 'Contact',
        ]);
        Permission::create([
            'name' => 'Update Contact',
            'group_name' => 'Contact',
        ]);
        Permission::create([
            'name' => 'Remove Contact',
            'group_name' => 'Contact',
        ]);


        Permission::create([
            'name' => 'Lead List',
            'group_name' => 'Lead',
        ]);
        Permission::create([
            'name' => 'Only Assigned Lead List',
            'group_name' => 'Lead',
        ]);
        Permission::create([
            'name' => 'View Lead',
            'group_name' => 'Lead',
        ]);
        Permission::create([
            'name' => 'Add Lead',
            'group_name' => 'Lead',
        ]);
        Permission::create([
            'name' => 'Update Lead',
            'group_name' => 'Lead',
        ]);
        Permission::create([
            'name' => 'Can Comment',
            'group_name' => 'Lead',
        ]);
        Permission::create([
            'name' => 'Remove Lead',
            'group_name' => 'Lead',
        ]);


        Permission::create([
            'name' => 'Property List',
            'group_name' => 'Property',
        ]);

        Permission::create([
            'name' => 'Only Assigned Property List',
            'group_name' => 'Property',
        ]);
        Permission::create([
            'name' => 'View Property',
            'group_name' => 'Property',
        ]);
        Permission::create([
            'name' => 'Add Property',
            'group_name' => 'Property',
        ]);
        Permission::create([
            'name' => 'Update Property',
            'group_name' => 'Property',
        ]);
        Permission::create([
            'name' => 'Remove Property',
            'group_name' => 'Property',
        ]);

        Permission::create([
            'name' => 'Document List',
            'group_name' => 'Document',
        ]);

        Permission::create([
            'name' => 'Document Attach to Property',
            'group_name' => 'Document',
        ]);
        Permission::create([
            'name' => 'View Document',
            'group_name' => 'Document',
        ]);
        Permission::create([
            'name' => 'Add Document',
            'group_name' => 'Document',
        ]);
        Permission::create([
            'name' => 'Update Document',
            'group_name' => 'Document',
        ]);
        Permission::create([
            'name' => 'Remove Document',
            'group_name' => 'Document',
        ]);



        Permission::create([
            'name' => 'Project List',
            'group_name' => 'Project',
        ]);

        Permission::create([
            'name' => 'Only Assigned Project List',
            'group_name' => 'Project',
        ]);
        Permission::create([
            'name' => 'View Project',
            'group_name' => 'Project',
        ]);
        Permission::create([
            'name' => 'Add Project',
            'group_name' => 'Project',
        ]);
        Permission::create([
            'name' => 'Update Project',
            'group_name' => 'Project',
        ]);
        Permission::create([
            'name' => 'Remove Project',
            'group_name' => 'Project',
        ]);


        Permission::create([
            'name' => 'Task List',
            'group_name' => 'Task',
        ]);

        Permission::create([
            'name' => 'Only Assigned Task List',
            'group_name' => 'Task',
        ]);
        Permission::create([
            'name' => 'View Task',
            'group_name' => 'Task',
        ]);
        Permission::create([
            'name' => 'Add Task',
            'group_name' => 'Task',
        ]);
        Permission::create([
            'name' => 'Update Task',
            'group_name' => 'Task',
        ]);
        Permission::create([
            'name' => 'Remove Task',
            'group_name' => 'Task',
        ]);

        Permission::create([
            'name' => 'Site Visit List',
            'group_name' => 'Site Visit',
        ]);

        Permission::create([
            'name' => 'Only Assigned Site Visit List',
            'group_name' => 'Site Visit',
        ]);
        Permission::create([
            'name' => 'View Site Visit',
            'group_name' => 'Site Visit',
        ]);
        Permission::create([
            'name' => 'Add Site Visit',
            'group_name' => 'Site Visit',
        ]);
        Permission::create([
            'name' => 'Update Site Visit',
            'group_name' => 'Site Visit',
        ]);
        Permission::create([
            'name' => 'Remove Site Visit',
            'group_name' => 'Site Visit',
        ]);
        Permission::create([
            'name' => 'View Member Location History',
            'group_name' => 'Member Location',
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
