<?php

namespace Database\Seeders;

use App\Models\CompanyBranch;
use App\Models\CompanyMember;
use App\Models\Scopes\CompanyIdScope;
use App\Models\User;
use Illuminate\Database\Seeder;
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

        $companies = $users->where('type', User::TYPE_COMPANY );

        foreach( $companies as $item ){
            $roles = Role::where('user_id', $item->id )->get()->pluck('id');
            $memberUsers = $users->where('id', '!=', $item->id );
            foreach( $memberUsers as $memberItem ){
                $member = new CompanyMember();
                $member->email = $memberItem->email;
                $member->user_id = $memberItem->id ?? null;
                $member->company_id = $item->defaultCompany->id;
                $member->company_branch_id = CompanyBranch::whereCompanyId( $item->defaultCompany->id )->withoutGlobalScope(CompanyIdScope::class)->first()->id;
                $member->role_id = $roles->random( 1 )->First();
                $member->created_by = $item->id;
                $member->is_default = CompanyMember::FLAG_IS_DEFAULT_YES;
                $member->invite_status = CompanyMember::INVITE_STATUS_ACCEPT;
                $member->is_owner = CompanyMember::FLAG_IS_OWNER_NO;
                $member->save();

                setPermissionsTeamId( $item->defaultCompany->id );
                $memberItem->assignRole( $member->role_id );
                $memberItem->syncRoles( $member->role_id );
            }
        }
    }
}
