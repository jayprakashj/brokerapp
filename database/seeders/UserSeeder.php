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
                'email' => 'superadmin@brokerapp.com',
                'mobile' => '1234567891',
                'password' => 'Strong@123',
                'type' => User::TYPE_COMPANY,
                'company_name' => $faker->text(10),
            ],
            [
                'name' => $faker->text(10),
                'email' => 'user1@brokerapp.com',
                'mobile' => '1234567800',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'user1@brokerapp.com',
                'mobile' => '1234567801',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'user2@brokerapp.com',
                'mobile' => '1234567802',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'user3@brokerapp.com',
                'mobile' => '1234567803',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'user4@brokerapp.com',
                'mobile' => '1234567804',
                'password' => 'Strong@123',
                'type' => User::TYPE_INDIVIDUAL,
            ],
            [
                'name' => $faker->text(10),
                'email' => 'user5@brokerapp.com',
                'mobile' => '1234567805',
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
