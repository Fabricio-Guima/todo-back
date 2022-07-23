<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {

        // dd($request->all());
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas.'],
            ]);
        }

        //logout de outros devices
        // if ($request->has('logout_others_devices')) {
        //     $user->tokens()->delete();
        // };       

        $user->tokens()->delete();


        $token = $user->createToken($request->device_name)->plainTextToken;

        UserResource::withoutWrapping();
        return (new UserResource($user))->additional(['token' => $token]);
    }

    public function me()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['success' => true, 'msg' => 'Deslogado com sucesso']);
    }
}
