<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SubArea;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubAreaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the subArea can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list subareas');
    }

    /**
     * Determine whether the subArea can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubArea  $model
     * @return mixed
     */
    public function view(User $user, SubArea $model)
    {
        return $user->hasPermissionTo('view subareas');
    }

    /**
     * Determine whether the subArea can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create subareas');
    }

    /**
     * Determine whether the subArea can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubArea  $model
     * @return mixed
     */
    public function update(User $user, SubArea $model)
    {
        return $user->hasPermissionTo('update subareas');
    }

    /**
     * Determine whether the subArea can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubArea  $model
     * @return mixed
     */
    public function delete(User $user, SubArea $model)
    {
        return $user->hasPermissionTo('delete subareas');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubArea  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete subareas');
    }

    /**
     * Determine whether the subArea can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubArea  $model
     * @return mixed
     */
    public function restore(User $user, SubArea $model)
    {
        return false;
    }

    /**
     * Determine whether the subArea can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubArea  $model
     * @return mixed
     */
    public function forceDelete(User $user, SubArea $model)
    {
        return false;
    }
}
