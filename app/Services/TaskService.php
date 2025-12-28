<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TaskService {
    public function Create(array $data){
        return Task::create($data);
    }
    public function Update(int $id, array $data){
        return Task::find($id)->update($data);
    }
    public function Delete(Task $task){
        return $task->delete();
    }
    public function Get(int $id){
        return Task::find($id);
    }
    public function My(User $user){
        return $user->tasks();
    }
}