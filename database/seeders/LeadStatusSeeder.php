<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LeadStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LeadStatusSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        LeadStatus::truncate();
        Schema::enableForeignKeyConstraints();

        $leadStatuses = [
            'Open',
            'In Progress',
            'Qualified',
            'Disqualified',
            'Won'
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
