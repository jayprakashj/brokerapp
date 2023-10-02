<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CompanyBranch\AddBranchRequest;
use App\Http\Resources\Api\CompanyBranch\BranchEditResource;
use App\Http\Resources\Api\CompanyBranch\BranchPaginationResource;
use App\Models\CompanyBranch;
use App\Services\Database\CompanyBranchClass;
use Illuminate\Http\Request;

class CompanyBranchController extends Controller
{
    private $companyBranchClass;

    public function __construct( CompanyBranchClass $companyBranchClass )
    {
        $this->companyBranchClass = $companyBranchClass;
    }

    public function index ( Request $request ) {

        $branches = $this->companyBranchClass->getDefaultCompanyBranches( $request );
        return new BranchPaginationResource( $branches );
    }

    public function edit (CompanyBranch $branch ) {

        return new BranchEditResource( $branch );
    }

    public function store (AddBranchRequest $request ) {
        $response = [
            'message' => 'Success! Branch created successfully.'
        ];
        $code = 200;

        $branch = CompanyBranch::find( $request->input('id') );

        if( is_null( $branch ) ){
            $this->companyBranchClass->create( auth()->user(), $request );

        }else{
            $this->companyBranchClass->update( auth()->user(), $branch, $request );
            $response = [
                'message' => 'Success! Branch data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( CompanyBranch $branch ) {
        $code = 500;
        $branch->delete();
        $response = [
            'message' => 'Branch removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }
}
