<?php

namespace Database\Seeders;

use App\Models\PropertyImageTypeList;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertyImageTypeListSeeder extends Seeder
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
            'Floor Plan',
            'External Images',
            'Protected Images',
            'Room',
            'Property Banner',
            'Others',
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($data as $name){
                $obj = new PropertyImageTypeList();
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
