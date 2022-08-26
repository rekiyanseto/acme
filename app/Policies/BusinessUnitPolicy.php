<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BusinessUnit;
use Illuminate\Auth\Access\HandlesAuthorization;

class BusinessUnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the businessUnit can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list businessunits');
    }

    /**
     * Determine whether the businessUnit can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BusinessUnit  $model
     * @return mixed
     */
    public function view(User $user, BusinessUnit $model)
    {
        return $user->hasPermissionTo('view businessunits');
    }

    /**
     * Determine whether the businessUnit can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create businessunits');
    }

    /**
     * Determine whether the businessUnit can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BusinessUnit  $model
     * @return mixed
     */
    public function update(User $user, BusinessUnit $model)
    {
        return $user->hasPermissionTo('update businessunits');
    }

    /**
     * Determine whether the businessUnit can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BusinessUnit  $model
     * @return mixed
     */
    public function delete(User $user, BusinessUnit $model)
    {
        return $user->hasPermissionTo('delete businessunits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BusinessUnit  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete businessunits');
    }

    /**
     * Determine whether the businessUnit can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BusinessUnit  $model
     * @return mixed
     */
    public function restore(User $user, BusinessUnit $model)
    {
        return false;
    }

    /**
     * Determine whether the businessUnit can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\BusinessUnit  $model
     * @return mixed
     */
    public function forceDelete(User $user, BusinessUnit $model)
    {
        return false;
    }
}
