<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FunctionalLocation;
use Illuminate\Auth\Access\HandlesAuthorization;

class FunctionalLocationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the functionalLocation can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list functionallocations');
    }

    /**
     * Determine whether the functionalLocation can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FunctionalLocation  $model
     * @return mixed
     */
    public function view(User $user, FunctionalLocation $model)
    {
        return $user->hasPermissionTo('view functionallocations');
    }

    /**
     * Determine whether the functionalLocation can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create functionallocations');
    }

    /**
     * Determine whether the functionalLocation can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FunctionalLocation  $model
     * @return mixed
     */
    public function update(User $user, FunctionalLocation $model)
    {
        return $user->hasPermissionTo('update functionallocations');
    }

    /**
     * Determine whether the functionalLocation can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FunctionalLocation  $model
     * @return mixed
     */
    public function delete(User $user, FunctionalLocation $model)
    {
        return $user->hasPermissionTo('delete functionallocations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FunctionalLocation  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete functionallocations');
    }

    /**
     * Determine whether the functionalLocation can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FunctionalLocation  $model
     * @return mixed
     */
    public function restore(User $user, FunctionalLocation $model)
    {
        return false;
    }

    /**
     * Determine whether the functionalLocation can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\FunctionalLocation  $model
     * @return mixed
     */
    public function forceDelete(User $user, FunctionalLocation $model)
    {
        return false;
    }
}
