<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskDataRequest;
use App\Http\Resources\TaskResource;
use App\Services\AuthenticationService;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(private TaskService $taskService, private AuthenticationService $authService) {}

    public function create(TaskDataRequest $request) {
        $validated = $request->validated();
        $data = [
            ...$validated,
            'user_id'=>auth()->user()->id,
        ];
        $task = $this->taskService->create($data);
        return response()->json(new TaskResource($task), 201);
    }
}
