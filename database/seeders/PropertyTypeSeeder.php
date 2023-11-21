<?php

namespace Database\Seeders;

use App\Models\PropertySubTypeList;
use App\Models\User;
use App\Models\PropertyTypeList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PropertyTypeList::truncate();
        PropertySubTypeList::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Residential' => [
                'Bunglows',
                'Duplex',
                'Flats',
                'Villa'
            ],
            'Commercial' => [
                'Offices',
                'Shops',
                'Showrooms'
            ],
            'Land' => [
                'Agriculture Land',
                'Open Land',
                'NonAgriculture Land'
            ],
            'Farmhouses' => [
                'Farmhouses'
            ],
            'Industrial' => [
                'Industrial'
            ],
            'Resident-Commercial' => [
                'Resident-Commercial'
            ]
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item  ){
            foreach($data as $name => $subTypes ){
                $obj = new PropertyTypeList();
                $obj->user_id = $item->id;
                $obj->created_by = $item->id;
                $obj->updated_by = $item->id;
                $obj->company_id = $item->defaultCompany->id;
                $obj->name = $name;
                $obj->save();

                foreach( $subTypes as $typeTitle ){
                    $subObj = new PropertySubTypeList();
                    $subObj->user_id = $item->id;
                    $subObj->created_by = $item->id;
                    $subObj->updated_by = $item->id;
                    $subObj->company_id = $item->defaultCompany->id;
                    $subObj->property_type_id = $obj->id;
                    $subObj->name = $typeTitle;
                    $subObj->save();

                }
            }
        }
    }
}
