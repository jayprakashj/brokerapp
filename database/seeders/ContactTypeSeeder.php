<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\CompanyBranch;
use App\Models\ContactType;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
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
            'Tenants',
            'Investor',
            'Builder',
            'Builder Executive',
            'Visitors',
            'Others',
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($contactTypes as $name){
                $contactType = new ContactType();
                $contactType->user_id = $item->id;
                $contactType->created_by = $item->id;
                $contactType->updated_by = $item->id;
                $contactType->company_id = $item->defaultCompany->id;
                $contactType->name = $name;
                $contactType->save();

            }
        }
    }
}
