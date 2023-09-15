<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\CompanyBranch;
use App\Models\ContactType;
use App\Models\CustomerType;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{

    public function __construct()
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $contactTypes = [
            'Buyer',
            'Seller',
            'Tenants'
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($contactTypes as $name){
                $customerType = new CustomerType();
                $customerType->user_id = $item->id;
                $customerType->created_by = $item->id;
                $customerType->updated_by = $item->id;
                $customerType->company_id = $item->defaultCompany->id;
                $customerType->name = $name;
                $customerType->save();

            }
        }
    }
}
