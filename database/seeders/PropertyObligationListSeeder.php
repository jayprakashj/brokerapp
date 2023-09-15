<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PropertyObligationList;
use Illuminate\Database\Seeder;

class PropertyObligationListSeeder extends Seeder
{

    public function __construct()
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            'Family',
            'Couples',
            'Singles'
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($data as $name){
                $obj = new PropertyObligationList();
                $obj->user_id = $item->id;
                $obj->created_by = $item->id;
                $obj->updated_by = $item->id;
                $obj->company_id = $item->defaultCompany->id;
                $obj->name = $name;
                $obj->save();

            }
        }
    }
}
