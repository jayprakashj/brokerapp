<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\CompanyCreateRequest;
use App\Models\Company;
use App\Models\CompanyMember;
use App\Models\User;
use App\Services\Database\MemberClass;

class MemberController extends Controller
{
    private $memberClass;

    public function __construct( MemberClass $memberClass )
    {
        $this->memberClass = $memberClass;
    }

    public function index () {
        $menus = [
            [
                'title' => 'Add Member',
                'icon_class' => 'fa-plus',
                'link' => route('member.create')
            ]
        ];
        $members = $this->memberClass->getDefaultCompanyMembers();
        $data = compact( 'menus', 'members' );
        return view('member.index', $data);
    }

    public function create (CompanyMember $member ) {
        $breadcrumbs = [
            [
                'title' => 'Member Management',
                'link' => route('member.index')
            ],
            [
                'title' => 'Add',
            ]
        ];
        if( $member->id ){
            $title = 'Update member';
        }else{
            $title = 'Add member';

        }
        $companies = auth()->user()->associatedCompanies()->get();
        $roles = auth()->user()->userRoles()->get();
        return view('member.create', compact('breadcrumbs', 'title', 'member', 'companies', 'roles') );
    }

    public function store (AddMemberRequest $request ) {
        $message = 'Success! Invitation sent successfully.';
        $member = CompanyMember::find( $request->input('id') );
        if( is_null( $member ) ){
            $this->memberClass->create( auth()->user(), $request );

        }else{
            $message = 'Success! User invitation updated successfully.';
            $this->memberClass->update( auth()->user(), $member, $request );

        }
        return redirect()->route('member.index')->with('success-message', $message);
    }

    public function viewInvitation ( CompanyMember $token ) {
        if( $token->email == auth()->user()->email  ){
            return view('member.view-invitation')->with('member', $token );
        }
        abort( 404 );
    }

    public function acceptInvitation ( CompanyMember $member ) {
        if( $member->email == auth()->user()->email ){
            $this->memberClass->acceptInvitation( $member );
            return redirect()->route('company.index')->with('success-message', 'Success! Company attached with you successfully.');
        }
        abort( 404 );
    }
}
