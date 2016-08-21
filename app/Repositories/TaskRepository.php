<?php

/**
 * Created by PhpStorm.
 * User: Nimo
 * Date: 21/08/2016
 * Time: 11:02 CH
 */


namespace App\Repositories;

use App\User;


class TaskRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User $user
     * @return Collection
     */

    public function forUser(\App\User $user)
    {
        return $user->tasks()->orderBy('created_at', 'asc')->get();
    }
}