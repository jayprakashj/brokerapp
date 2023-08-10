<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCreateRequest;
use App\Models\Company;
use App\Services\Database\CompanyClass;

class CompanyController extends Controller
{
    private $companyClass;

    public function __construct( CompanyClass $companyClass )
    {
        $this->companyClass = $companyClass;
    }

    public function index () {
        $menus = [
            [
                'title' => 'Create',
                'icon_class' => 'fa-plus',
                'link' => route('company.create')
            ]
        ];
        $companies = Company::with(['authMember'])
                                ->whereHas('members', function ( $q ) {
                                    $q->whereUserId( auth()->id() )
                                        ->acceptedInvite();
                                })
                                ->paginate(10);
        $data = compact( 'menus', 'companies' );
        return view('company.index', $data);
    }

    public function create (Company $company ) {
        $breadcrumbs = [
            [
                'title' => 'Company Management',
                'link' => route('company.index')
            ],
            [
                'title' => 'Create',
            ]
        ];
        $title = 'Create Company';
        return view('company.create', compact('breadcrumbs', 'title', 'company') );
    }

    public function store (CompanyCreateRequest $request ) {
        $message = 'Success! Company created successfully.';
        $company = Company::find( $request->input('id') );
        $request->merge([
            'status' => $request->has('status')
        ]);
        if( is_null( $company ) ){
            $this->companyClass->create( auth()->user(), $request );

        }else{
            if( $company->isOwnedByMe() ){

                $message = 'Success! Company updated successfully.';
                $this->companyClass->update( auth()->user(), $company, $request );
            }else{

                return redirect()->route('company.index')->with('error-message', 'Error! You can not edit the company which is not created by you.');
            }

        }
        return redirect()->route('company.index')->with('success-message', $message);
    }

    public function makeDefault ( Company $company ){
        if( $company->isActive() )
        {
            $this->companyClass->makeDefault( $company );
            return redirect()->route('company.index')->with('success-message', 'Success! Default company changed to '.$company->name.'.');
        }else{
            return redirect()->bcvk()->with('error-message', 'Error! Company must be active to cmake the default.');

        }
    }

    public function changeStatus ( Company $company ){
        if( !$company->isDefault() )
        {
            $this->companyClass->changeStatus( $company );
            return redirect()->route('company.index')->with('success-message', 'Success! Company with name '.$company->name.' status has been changed successfully.');
        }else{
            return redirect()->bcvk()->with('error-message', 'Error! Default company can not change the status.');

        }
    }
}
