<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PropertyTransactionList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                PermissionSeeder::class,
                UserSeeder::class,
                RoleSeeder::class,
                BranchSeeder::class,
                MemberSeeder::class,
                ContactTypeSeeder::class,
                CustomerTypeSeeder::class,
                LeadSourceSeeder::class,
                LeadStatusSeeder::class,
                PropertyTypeSeeder::class,
                PropertyTransactionSeeder::class,
                PropertyFurnishSeeder::class,
                PropertyFacingListSeeder::class,
                PropertyObligationListSeeder::class,
                PropertyImageTypeListSeeder::class,
            ]
        );
    }
}
