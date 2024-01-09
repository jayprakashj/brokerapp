<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PropertyTransactionList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PropertyTransactionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        PropertyTransactionList::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Sell',
            'Rental',
            // 'Resell',
            'Pre-Leased'
        ];
        $users = User::with('defaultCompany')->typeCompany()->get();
        foreach( $users as $item ){
            foreach($data as $name){
                $obj = new PropertyTransactionList();
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
