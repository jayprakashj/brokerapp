<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\AddTaskRequest;
use App\Http\Resources\Api\Task\TaskEditResource;
use App\Http\Resources\Api\Task\TaskPaginationResource;
use App\Http\Resources\Api\Task\TaskStatusListForSelectList;
use App\Http\Resources\Api\Task\TaskViewResource;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Services\Database\TaskClass;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskClass;

    public function __construct( )
    {
        $this->taskClass = new TaskClass;
    }

    public function index ( Request $request ) {
        $user = auth()->user();

        $onlyAssignedTo = $user->can('Only Assigned Task List');
        if( $user->isCompanyAdmin() ){
            $onlyAssignedTo = false;
        }
        $branches = $this->taskClass->getDefaultCompanyTasks( $request->input('per_page', 24 ), $onlyAssignedTo);
        return new TaskPaginationResource( $branches );
    }

    public function edit (Task $task ) {
        if( !$task->checkAuthorization() ){
            return response()->json( [], 404 );
        }
        return new TaskEditResource( $task );
    }

    public function view (Task $task ) {

        if( !$task->checkAuthorization() ){
            return response()->json( [], 404 );
        }

        return new TaskViewResource( $task );
    }

    public function store (AddTaskRequest $request ) {
        $response = [
            'message' => 'Success! New Task added successfully.'
        ];
        $code = 200;

        $task = Task::find( $request->input('id') );

        if( is_null( $task ) ){
            $this->taskClass->create( auth()->user(), $request );

        }else{

            if( !$task->checkAuthorization() ){
                return response()->json( [], 404 );
            }
            $this->taskClass->update( auth()->user(), $task, $request );
            $response = [
                'message' => 'Success! Task data updated successfully.'
            ];
        }
        return response()->json( $response, $code );
    }


    public function delete ( Task $task ) {
        $code = 500;
        $task->delete();
        $response = [
            'message' => 'Task removed successfully.'
        ];
        $code = 200;
        return response()->json( $response , $code);
    }

    public function taskStatusSelectList ( Request $request ){
        $list = TaskStatus::select('id', 'name')->get();
        return TaskStatusListForSelectList::collection( $list );
    }

}
