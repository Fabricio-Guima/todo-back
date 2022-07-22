<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //super admin com acesso a tudo
    // public function before(User $user)
    // {
    //     if (($user->isSuperAdmin())) {
    //         return true;
    //     }
    // }

    //index e show
    public function view(User $user, Todo $todo)
    {
        return $user->id === $todo->user_id;
    }

    //addTask
    public function addTask(User $user, Todo $todo)
    {
        return $user->id === $todo->user_id;
    }

    //update
    public function update(User $user, Todo $todo)
    {
        return $user->id === $todo->user_id;
    }

    //destroy
    public function destroy(User $user, Todo $todo)
    {
        return $user->id === $todo->user_id;
    }
}
