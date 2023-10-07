<?php

namespace App\Models;

use App\Models\Relations\CompanyRelation;
use App\Models\Relations\CreatedUpdatedUserRelation;
use App\Models\Relations\OwnerUserRelation;
use App\Models\Scopes\CommonFilter;
use App\Models\Scopes\CompanyIdScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use CompanyRelation, CreatedUpdatedUserRelation, OwnerUserRelation, SoftDeletes, CommonFilter;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyIdScope);
    }

    public function assignToUser (){
        return $this->belongsTo( User::class, 'assign_to', 'id');
    }

    public function scopeCreatedByOrAssignedToAuth ( $q ){
        return $q->where(function( $whereQry ){
            $whereQry->assignedToAuth( 'or' )
                        ->createdByAuth( 'or' );
        });
    }

    public function isAssignedToMe(){
        return $this->assign_to == auth()->id();
    }

    public function checkAuthorization(){
        $user = auth()->user();
        return ($user->isCompanyAdmin() || ($user->can('Only Assigned Task List') && $this->isAssignedToMe()));
    }

    public function scopeCustomSort( $q, $sortColumn, $sortOrder = 'asc' ){
        if( !empty( $sortColumn ) ){
            switch( $sortColumn ){
                case 'title':
                    $q->orderBy( 'title', $sortOrder);
                    break;
                case 'status':
                    $q->orderBy( 'status', $sortOrder);
                    break;
                case 'scheduled_date':
                    $q->orderBy( 'scheduled_date', $sortOrder);
                    break;
                case 'assign_to':
                    $q->orderBy( User::select('name')->whereColumn('id', 'tasks.assign_to')->limit(1) , $sortOrder);
                    break;
                case 'updated_at':
                    $q->orderBy( 'updated_at', $sortOrder);
                    break;
            }
        }

        return $q;
    }

    public function scopeCustomFilter( $q, $filter ){

        if( !empty( $filter ) ){
            $title = data_get( $filter, 'title' );
            $status = data_get( $filter, 'status' );
            $assignTo = data_get( $filter, 'assign_to' );
            $scheduledDate = data_get( $filter, 'scheduled_date' );
            if( !empty( $title ) ){
                $q->filterTitleLike( $title );
            }
            if( !empty( $status ) ){
                $q->filterStatus( $status );
            }
            if( !is_null( $assignTo ) ){
                $q->filterAssignTo( $assignTo );
            }
            if( !is_null( $scheduledDate ) ){
                $dt = explode(' to ', $scheduledDate);
                $q->filterDate( 'scheduled_date',$dt );
            }
        }
        return $q;
    }

    public function scopeFilterTitleLike ( $q, $value, $boolean = 'and' ){
        return $q->where('title', 'LIKE', '%'. $value . '%', $boolean);
    }

    public function scopeFilterStatus ( $q, $value, $boolean = 'and' ){
        return $q->where('status', '=', $value, $boolean);
    }
}
