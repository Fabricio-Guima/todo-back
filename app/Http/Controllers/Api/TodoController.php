<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TodoResource;
use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TodoController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        return TodoResource::collection(auth()->user()->todos()->paginate(9));
    }

    public function show(Todo $todo)
    {
        $this->authorize('view', $todo);

        return new TodoResource($todo);
    }

    public function getAllTasksFromTodo(Todo $todo)
    {
        $this->authorize('view', $todo);

        return TodoResource::collection($todo->tasks()->paginate(9));
    }

    public function store(TodoRequest $request)
    {
        // $user = $request->user();

        $data = $request->validated();
        $todo =  auth()->user()->todos()->create($data);

        return response()->json(new TodoResource($todo));
    }

    public function update(Todo $todo, TodoRequest $request)
    {
        $this->authorize('update', $todo);

        if (isset($todo->done)) {
            throw ValidationException::withMessages(['msg' => 'Não é possível atualizar os dados informados.']);
        }

        $data = $request->validated();
        $data["user_id"] = auth()->user()->id;
        $todo->fill($data);
        $todo->save();


        return response()->json(new TodoResource($todo->fresh()));
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('destroy', $todo);

        $todo->delete();

        return response()->json(['success' => true, 'msg' => 'Registro deletado com sucesso.']);
    }

    public function addTask(Todo $todo, TaskRequest $request)
    {
        $this->authorize('addTask', $todo);

        $data = $request->all();
        $data["user_id"] = auth()->user()->id;
        $task = $todo->tasks()->create($data);

        return response()->json(new TaskResource($task));
    }
}
