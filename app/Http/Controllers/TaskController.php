<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskDataRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\AuthenticationService;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
class TaskController extends Controller
{
    public function __construct(private TaskService $taskService, private AuthenticationService $authService) {}

    /**
     * handles creation of a task. any authenticated user can create a task.
     */
    public function create(TaskDataRequest $request) {
        $validated = $request->validated();

        $user = auth()->user(); 

        $task = $this->taskService->create([
            ...$validated,
            'user_id'=>$user->id,
        ]);

        event(new TaskAssignedEvent($user, $task));

        return response()->json(new TaskResource($task), 201);
    }

    /**
     * ;ist of all the tasks of the current user
     */
    public function my(Request $request) {

        $perPage = $request->input('per_page', 1);
        
        $tasks = $this->taskService->MyTasks(auth()->user(), $perPage);

        return TaskResource::collection($tasks)->additional([
            'meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
                'links' => [
                    'next' => $tasks->nextPageUrl(),
                    'prev' => $tasks->previousPageUrl(),
                ]
            ],
        ]);
    }

    public function detail(Request $request, Task $task){
        return new TaskResource($task);
    }

    public function update(TaskDataRequest $request, Task $task) {
        $validated = $request->validated();
        $task = $this->taskService->update($task, $validated);
        return new TaskResource($task);
    }

    public function delete(Task $task) {
        $this->taskService->Delete($task);
        return new TaskResource(new Task());
    }
}
