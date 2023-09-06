<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PropertyTypeList;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
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
            'Residential',
            'Commercial',
            'Land'
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($data as $name){
                $obj = new PropertyTypeList();
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
