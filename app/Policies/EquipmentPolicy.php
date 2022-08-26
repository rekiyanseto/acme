<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EquipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the equipment can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list equipments');
    }

    /**
     * Determine whether the equipment can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Equipment  $model
     * @return mixed
     */
    public function view(User $user, Equipment $model)
    {
        return $user->hasPermissionTo('view equipments');
    }

    /**
     * Determine whether the equipment can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create equipments');
    }

    /**
     * Determine whether the equipment can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Equipment  $model
     * @return mixed
     */
    public function update(User $user, Equipment $model)
    {
        return $user->hasPermissionTo('update equipments');
    }

    /**
     * Determine whether the equipment can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Equipment  $model
     * @return mixed
     */
    public function delete(User $user, Equipment $model)
    {
        return $user->hasPermissionTo('delete equipments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Equipment  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete equipments');
    }

    /**
     * Determine whether the equipment can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Equipment  $model
     * @return mixed
     */
    public function restore(User $user, Equipment $model)
    {
        return false;
    }

    /**
     * Determine whether the equipment can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Equipment  $model
     * @return mixed
     */
    public function forceDelete(User $user, Equipment $model)
    {
        return false;
    }
}
