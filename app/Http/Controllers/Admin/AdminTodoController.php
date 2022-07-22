<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminTodoController extends Controller
{
    public function __construct()
    {
    }
    //só admin
    public function indexAdmin()
    {
        return TodoResource::collection(Todo::paginate(9));
    }

    public function showAdmin(Todo $todo)
    {
        return response()->json(new TodoResource($todo));
    }

    public function storeAdmin(TodoRequest $request)
    {
        // $user = $request->user();

        $data = $request->validated();
        $todo =  auth()->user()->todos()->create($data);

        return response()->json(new TodoResource($todo));
    }

    public function updateAdmin(Todo $todo, TodoRequest $request)
    {

        if (!empty($todo->done)) {
            throw ValidationException::withMessages(['msg' => 'Não é possível atualizar os dados informados.']);
        }

        $data =  $request->validated();
        $data["user_id"] = $todo->user_id;
        $todo->fill($data);
        $todo->save();


        return response()->json(new TodoResource($todo));
    }


    public function addTaskAdmin(Todo $todo, TaskRequest $request)
    {
        $data = $request->all();
        $data["user_id"] = auth()->user()->id;
        $task = $todo->tasks()->create($data);

        return response()->json(new TaskResource($task));
    }

    public function destroyAdmin(Todo $todo)
    {
        $todo->delete();

        return response()->json(['success' => true, 'msg' => 'Registro deletado com sucesso.']);
    }
}
