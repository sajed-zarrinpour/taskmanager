<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TaskService {
    public function Create(array $data){
        return Task::create($data);
    }
    public function Update(Task $task, array $data){
        $task->update($data);
        return $task;
    }
    public function Delete(Task $task){
        return $task->delete();
    }
    public function Get(int $id){
        return Task::find($id);
    }
    public function MyTasks(User $user, string $search_col = '', mixed $search_val=null, string $order_by = 'id', string $direction = 'asc', int $perPage){
        $query = Task::query();
        switch ($search_col) {
            case 'status':
                $query->where($search_col, '=', $search_val);
                break;
            case 'due_date':
                $date = Carbon::parse($search_val);
                $query->where($search_col, '=', $date);
                break;
            
            default:
                # code...
                break;
        }

        return $query->orderBy($order_by, strtolower($direction))->paginate($perPage);
    }
}