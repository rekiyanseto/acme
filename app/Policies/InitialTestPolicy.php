<?php

namespace App\Policies;

use App\Models\User;
use App\Models\InitialTest;
use Illuminate\Auth\Access\HandlesAuthorization;

class InitialTestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the initialTest can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list initialtests');
    }

    /**
     * Determine whether the initialTest can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InitialTest  $model
     * @return mixed
     */
    public function view(User $user, InitialTest $model)
    {
        return $user->hasPermissionTo('view initialtests');
    }

    /**
     * Determine whether the initialTest can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create initialtests');
    }

    /**
     * Determine whether the initialTest can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InitialTest  $model
     * @return mixed
     */
    public function update(User $user, InitialTest $model)
    {
        return $user->hasPermissionTo('update initialtests');
    }

    /**
     * Determine whether the initialTest can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InitialTest  $model
     * @return mixed
     */
    public function delete(User $user, InitialTest $model)
    {
        return $user->hasPermissionTo('delete initialtests');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InitialTest  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete initialtests');
    }

    /**
     * Determine whether the initialTest can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InitialTest  $model
     * @return mixed
     */
    public function restore(User $user, InitialTest $model)
    {
        return false;
    }

    /**
     * Determine whether the initialTest can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\InitialTest  $model
     * @return mixed
     */
    public function forceDelete(User $user, InitialTest $model)
    {
        return false;
    }
}
