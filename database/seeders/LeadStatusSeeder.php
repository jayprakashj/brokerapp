<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContactType;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusSeeder extends Seeder
{

    public function __construct()
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $leadStatuses = [
            'In Progress',
            'Qualified',
            'Disqualified'
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($leadStatuses as $name){
                $leadStatus = new LeadStatus();
                $leadStatus->user_id = $item->id;
                $leadStatus->created_by = $item->id;
                $leadStatus->updated_by = $item->id;
                $leadStatus->company_id = $item->defaultCompany->id;
                $leadStatus->name = $name;
                $leadStatus->save();

            }
        }
    }
}
