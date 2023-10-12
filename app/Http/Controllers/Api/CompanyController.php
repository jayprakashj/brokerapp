<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Services\Database\CompanyClass;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\UpdateCompanySettingRequest;
use App\Http\Resources\Api\Company\CompanyEditResource;
use App\Http\Resources\Api\Company\DefaultCompanyResource;
use App\Http\Resources\Api\Company\CompanyPaginationResource;
use App\Http\Resources\Api\Company\CompanySettingResource;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $companyClass;

    public function __construct( CompanyClass $companyClass )
    {
        $this->companyClass = $companyClass;
    }

    public function index ( Request $request ) {

        $companies = $this->companyClass->fetchCompaniesList( auth()->user(), $request->input('per_page', 10 ) );

        return response()->json( new CompanyPaginationResource( $companies ), 200 );
    }

    public function edit (Company $company ) {
        $response = [
            'message' => ''
        ];
        $code = 200;
        if( $company->isOwnedByMe() ){
            $response = new CompanyEditResource( $company );
        }else{

            $response = [
                'message' => 'Error! You are not allowed to edit the company.'
            ];
            $code = 500;
        }

        return response()->json( $response, $code );
    }

    public function store (CompanyCreateRequest $request ) {
        $response = [
            'message' => 'Success! Company created successfully.'
        ];
        $code = 200;

        $company = Company::find( $request->input('id') );


        if( is_null( $company ) ){

            // $this->companyClass->create( auth()->user(), $request );
            $response = [
                'message' => 'Oops! You are not able to add the extra company.'
            ];
            $code = 500;
        }else{
            if( $company->isOwnedByMe() ){
                if( !auth()->user()->isTypeIndividual() ){

                    $company = $this->companyClass->update( auth()->user(), $company, $request );

                    $response = [
                        'message' => 'Success! Company data updated successfully.',
                        'data' => new DefaultCompanyResource( $company )
                    ];
                }else{
                    $response = [];
                    $code = 404;
                }
            }else{
                $response = [
                    'message' => 'Error! You can not edit the company which is not created by you.'
                ];
                $code = 500;
            }

        }

        return response()->json( $response, $code );
    }

    public function makeDefault ( Company $company ){

        $response = [
            'message' => ''
        ];
        $code = 500;

        if( !(auth()->user()->isTypeIndividual() && $company->isOwnedByMe() )){

            if( $company->isActive() )
            {
                $this->companyClass->makeDefault( $company );

                $response = [
                    'message' => 'Success! Default company changed to '.$company->name.'.',
                    'new_permissions' =>  auth()->user()->getAllPermissions()->pluck('name'),
                    'company_data' => new DefaultCompanyResource( $company )
                ];
                $code = 200;
            }else{

                $response = [
                    'message' => 'Error! Company must be active to cmake the default.'
                ];

            }
        }else{
            $response = [];
            $code = 404;
        }
        return response()->json( $response, $code );
    }

    public function changeStatus ( Company $company ){
        $response = [
            'message' => ''
        ];
        $code = 500;
        if( !$company->isDefault() )
        {
            if( $company->isOwnedByMe() )
            {
                $this->companyClass->changeStatus( $company );

                $response = [
                    'message' => 'Success! Company with name '.$company->name.' status has been changed successfully.'
                ];
                $code = 200;

            }else{
                $response = [
                    'message' => 'Error! You can\'t change the status of the Company that not owned by you.'
                ];
            }
        }else{
            $response = [
                'message' => 'Error! Default company can not change the status.'
            ];
        }

        return response()->json( $response, $code );
    }

    public function getCompanySetting(){

        $data = new CompanySettingResource( \Helper::retrieveDefaultCompany() );
        return response()->json( $data, 200 );
    }

    public function updateCompanySetting( UpdateCompanySettingRequest $request ){
        $code = 200;
        $response = [
            'message' => 'Success! Company Setting has been updated.'
        ];

        $this->companyClass->updateCompanySettings( $request );

        return response()->json( $response, $code );
    }
}
