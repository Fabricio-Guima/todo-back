<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
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

    //index e show
    public function view(User $user, Task $task)
    {
        return $user->id === $task->todo->user_id;
    }

    //addTask
    public function addTask(User $user, Task $task)
    {
        return $user->id === $task->todo->user_id;
    }

    //update
    public function update(User $user, Task $task)
    {
        return $user->id === $task->todo->user_id;
    }

    //destroy
    public function destroy(User $user, Task $task)
    {
        return $user->id === $task->todo->user_id;
    }
}
