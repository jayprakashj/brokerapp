<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContactType;
use App\Models\LeadSource;
use Illuminate\Database\Seeder;

class LeadSourceSeeder extends Seeder
{

    public function __construct()
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $leadSources = [
            '99Acres.com',
            'Gujarat Samachar',
            'CRM',
            'Facebook',
            'Housing.com',
            'Incoming Call',
            'JustDial.com',
            'MagicBricks.com',
            'Makaan.com',
            'Own Website',
            'Others',
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($leadSources as $name){
                $leadSource = new LeadSource();
                $leadSource->user_id = $item->id;
                $leadSource->created_by = $item->id;
                $leadSource->updated_by = $item->id;
                $leadSource->company_id = $item->defaultCompany->id;
                $leadSource->name = $name;
                $leadSource->save();

            }
        }
    }
}
