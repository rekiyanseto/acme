<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MaintenanceDocument;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenanceDocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the maintenanceDocument can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list maintenancedocuments');
    }

    /**
     * Determine whether the maintenanceDocument can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaintenanceDocument  $model
     * @return mixed
     */
    public function view(User $user, MaintenanceDocument $model)
    {
        return $user->hasPermissionTo('view maintenancedocuments');
    }

    /**
     * Determine whether the maintenanceDocument can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create maintenancedocuments');
    }

    /**
     * Determine whether the maintenanceDocument can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaintenanceDocument  $model
     * @return mixed
     */
    public function update(User $user, MaintenanceDocument $model)
    {
        return $user->hasPermissionTo('update maintenancedocuments');
    }

    /**
     * Determine whether the maintenanceDocument can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaintenanceDocument  $model
     * @return mixed
     */
    public function delete(User $user, MaintenanceDocument $model)
    {
        return $user->hasPermissionTo('delete maintenancedocuments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaintenanceDocument  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete maintenancedocuments');
    }

    /**
     * Determine whether the maintenanceDocument can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaintenanceDocument  $model
     * @return mixed
     */
    public function restore(User $user, MaintenanceDocument $model)
    {
        return false;
    }

    /**
     * Determine whether the maintenanceDocument can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\MaintenanceDocument  $model
     * @return mixed
     */
    public function forceDelete(User $user, MaintenanceDocument $model)
    {
        return false;
    }
}
