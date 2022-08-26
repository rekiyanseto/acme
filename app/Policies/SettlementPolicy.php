<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Settlement;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettlementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the settlement can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list settlements');
    }

    /**
     * Determine whether the settlement can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Settlement  $model
     * @return mixed
     */
    public function view(User $user, Settlement $model)
    {
        return $user->hasPermissionTo('view settlements');
    }

    /**
     * Determine whether the settlement can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create settlements');
    }

    /**
     * Determine whether the settlement can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Settlement  $model
     * @return mixed
     */
    public function update(User $user, Settlement $model)
    {
        return $user->hasPermissionTo('update settlements');
    }

    /**
     * Determine whether the settlement can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Settlement  $model
     * @return mixed
     */
    public function delete(User $user, Settlement $model)
    {
        return $user->hasPermissionTo('delete settlements');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Settlement  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete settlements');
    }

    /**
     * Determine whether the settlement can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Settlement  $model
     * @return mixed
     */
    public function restore(User $user, Settlement $model)
    {
        return false;
    }

    /**
     * Determine whether the settlement can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Settlement  $model
     * @return mixed
     */
    public function forceDelete(User $user, Settlement $model)
    {
        return false;
    }
}
