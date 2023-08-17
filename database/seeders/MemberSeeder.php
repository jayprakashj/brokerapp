<?php

namespace Database\Seeders;

use App\Models\CompanyMember;
use App\Models\User;
use App\Services\Database\UserClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MemberSeeder extends Seeder
{

    public function __construct(  )
    {
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::with('defaultCompany')->get();

        foreach( $users as $item ){
            $roles = Role::where('user_id', $item->id )->get()->pluck('id');
            $memberUsers = $users->where('id', '!=', $item->id );
            foreach( $memberUsers as $memberItem ){
                $member = new CompanyMember();
                $member->email = $memberItem->email;
                $member->user_id = $memberItem->id ?? null;
                $member->company_id = $item->defaultCompany->id;
                $member->role_id = $roles->random( 1 );
                $member->created_by = $item->id;
                $member->is_default = CompanyMember::FLAG_IS_DEFAULT_NO;
                $member->invite_status = CompanyMember::INVITE_STATUS_ACCEPT;
                $member->is_owner = CompanyMember::FLAG_IS_OWNER_NO;
                $member->save();
            }
        }
    }
}
