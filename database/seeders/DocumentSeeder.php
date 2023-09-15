<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Document;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DocumentSeeder extends Seeder
{

    public function __construct()
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = app( Faker::class );

        $users = User::with('defaultCompany')->typeCompany()->get();
        for($i = 0; $i < 8; $i++){
            $item = $users->random();
            $paragraphs = $faker->paragraphs(rand(2, 6));
            $content = '<b>' . $faker->text( 10 ) . '</b>';
            foreach( $paragraphs as $content){
                $content .= '<p>' . $content . '</p>';

            }
            $obj = new Document();
            $obj->user_id = $item->id;
            $obj->created_by = $item->id;
            $obj->updated_by = $item->id;
            $obj->company_id = $item->defaultCompany->id;
            $obj->name = $faker->text( 10 );
            $obj->description = $faker->text( 10 );
            $obj->content = $content;
            $obj->save();

        }
    }
}
