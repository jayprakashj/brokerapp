<?php

namespace App\Services\Database;

use App\Models\Company;
use App\Models\CompanyUserPivot;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\User;
use Helper;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LeadCommentClass {

    public function create ( Lead $lead, $request, User $user ) {

        $leadComment = new LeadComment();
        $leadComment->user_id = \Helper::retrieveDefaultCompany()->owned_by ?? null;
        $leadComment->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $leadComment->lead_id = $lead->id;
        $leadComment->created_by = $user->id;
        $leadComment->updated_by = $user->id;
        $leadComment->comment = $request->input('comment', 'New Lead Generated');
        $leadComment->lead_status = $lead->lead_status;
        $leadComment->followup_date = $lead->followup_date;
        $leadComment->save();
    }

    public function createWithLeadUpdate ( Lead $lead, User $user ) {

        $changesField = $lead->getChanges();
        if( !empty( $changesField ) ){
            $comment = \Helper::combineKeyValue( $changesField );
            $leadComment = new LeadComment();
            $leadComment->user_id = \Helper::retrieveDefaultCompany()->owned_by ?? null;
            $leadComment->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
            $leadComment->lead_id = $lead->id;
            $leadComment->created_by = $user->id;
            $leadComment->updated_by = $user->id;
            $leadComment->comment = implode("\n", $comment );
            $leadComment->lead_status = $lead->lead_status;
            $leadComment->followup_date = $lead->followup_date;
            $leadComment->save();
        }

    }


}
