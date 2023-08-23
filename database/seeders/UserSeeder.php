<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Database\UserClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

class UserSeeder extends Seeder
{
    private $userClass;

    public function __construct( UserClass $userClass )
    {
        $this->userClass = $userClass;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = app( Faker::class );

        $data = [
            [
                'name' => $faker->text(10),
                'email' => 'companyuser@mailinator.com',
                'mobile' => '1234567891',
                'password' => 'Strong@123',
                'type' => User::TYPE_COMPANY,
                'company_name' => $faker->text(10),
            ],
            [
                'name' => $faker->text(10),
                'email' => 'companyuser1@mailinator.com',
                'mobile' => '2234567891',
                'password' => 'Strong@123',
                'type' => User::TYPE_COMPANY,
                'company_name' => $faker->text(10),
            ],
            [
                'name' => $faker->text(10),
                'email' => 'companyuser2@mailinator.com',
                'mobile' => '3234567891',
                'password' => 'Strong@123',
                'type' => User::TYPE_COMPANY,
                'company_name' => $faker->text(10),
            ],
            [
                'name' => $faker->text(10),
                'email' => 'individual@mailinator.com',
                'mobile' => '12345678000',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'member1@mailinator.com',
                'mobile' => '12345678001',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'member2@mailinator.com',
                'mobile' => '12345678002',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'member3@mailinator.com',
                'mobile' => '12345678003',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'member4@mailinator.com',
                'mobile' => '12345678004',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'member5@mailinator.com',
                'mobile' => '12345678005',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ]
        ];

        foreach( $data as $item ){
            $request = new Request( $item );
            setPermissionsTeamId( null );
            $user = $this->userClass->register( $request );
            $this->userClass->setEmailVerify( $user );
        }
    }
}
