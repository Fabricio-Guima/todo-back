<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function __construct()
    {
    }

    public function indexAdmin()
    {
        return TaskResource::collection(Task::with('todo.user')->paginate(9));
    }

    public function showAdmin(Task $task)
    {
        return response()->json(new TaskResource($task));
    }

    public function updateAdmin(Task $task, TaskRequest $request)
    {
        $data =  $request->validated();
        $task->fill($data);
        $task->save();

        return response()->json(new TaskResource($task->fresh()));
    }

    public function destroyAdmin(Task $task)
    {
        $task->delete();

        return response()->json(['success' => true, 'msg' => 'Registro deletado com sucesso.']);
    }
}
