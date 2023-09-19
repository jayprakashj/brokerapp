<?php

namespace App\Services\Database;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;

class TaskClass {

    public function __construct()
    {
    }

    public function getDefaultCompanyTasks ( $perPage = 24, $onlyAssignedTo = false, $onlyCreatedBy = false ) {

        $lists = Task::query()->with(['company']);

        if( $onlyAssignedTo ){
            $lists->createdByOrAssignedToAuth();
        }else if( $onlyCreatedBy ){
            $lists->createdByAuth();
        }

        $lists = $lists->paginate( $perPage );

        return $lists;
    }


    public function create ( User $user, $request ) {

        $task = new Task();
        $task->user_id = \Helper::retrieveDefaultCompany()->owned_by;
        $task->company_id = \Helper::retrieveDefaultCompany()->id ?? null;
        $task->created_by = $user->id;
        $task = $this->createOrUpdate( $task, $user, $request );


        return $task;
    }

    public function update ( User $user, Task $task, $request ){
        return $this->createOrUpdate( $task, $user, $request );
    }

    public function createOrUpdate( Task $task, User $user, $request ){



        $task->title = $request->input('title');
        $task->remark = $request->input('remark');
        $task->description = $request->input('description');
        $task->status = TaskStatus::whereName( $request->input('status') )->first()->name;
        $task->scheduled_date = $request->input('scheduled_date');
        $task->assign_to = $request->input('assign_to');
        $task->updated_by = $user->id;
        $task->save();

        if( !$task->wasRecentlyCreated ){
            $task->refresh();
        }

        return $task;
    }

}
