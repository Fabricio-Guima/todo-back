<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $tasks = auth()->user()->tasks()->get();
        return response()->json(TaskResource::collection($tasks));
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return response()->json(new TaskResource($task));
    }

    public function store(TaskRequest $request)
    {

        $data = $request->validated();
        $task = Task::create($data);

        return response()->json(new TaskResource($task));
    }

    public function update(Task $task, TaskRequest $request)
    {
        $this->authorize('update', $task);

        $data =  $request->validated();
        $task->fill($data);
        $task->save();

        return response()->json(new TaskResource($task->fresh()));
    }

    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return response()->json(['success' => true, 'msg' => 'Registro deletado com sucesso.']);
    }
}
