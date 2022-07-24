<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $tasks = auth()->user()->tasks()->paginate(9);
        return TaskResource::collection($tasks);
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

        if ($task->done) {
            throw ValidationException::withMessages(['msg' => 'Não é possível atualizar uma tarefa já concluída.']);
        }

        $data =  $request->validated();
        $data["user_id"] = auth()->user()->id;
        $task->fill($data);
        $task->save();

        return new TaskResource($task->fresh());
    }

    public function destroy(Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return response()->json(['success' => true, 'msg' => 'Registro deletado com sucesso.']);
    }
}
