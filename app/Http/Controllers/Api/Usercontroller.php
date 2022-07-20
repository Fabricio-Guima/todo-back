<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Usercontroller extends Controller
{

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $userExists = User::where('email', $data['email'])->exists();

        if (!empty($userExists)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return new UserResource($user);
    }

    public function update(User $userId, UserRequest $request)
    {
        $LoggedUser = auth()->user();
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();


        //nao deixo mudar de email
        if ($LoggedUser->id !== optional($user)->id) {

            throw ValidationException::withMessages(['message' => 'Não é possível atualizar os dados informados.']);
        }

        if ($request->password) {
            $data['password'] = bcrypt($data['password']);
        }

        $userId->fill($data);
        $userId->save();


        return new UserResource($userId);
    }
}
