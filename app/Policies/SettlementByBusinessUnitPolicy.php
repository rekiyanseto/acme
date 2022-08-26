<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SettlementByBusinessUnit;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettlementByBusinessUnitPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the settlementByBusinessUnit can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list settlementbybusinessunits');
    }

    /**
     * Determine whether the settlementByBusinessUnit can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SettlementByBusinessUnit  $model
     * @return mixed
     */
    public function view(User $user, SettlementByBusinessUnit $model)
    {
        return $user->hasPermissionTo('view settlementbybusinessunits');
    }

    /**
     * Determine whether the settlementByBusinessUnit can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create settlementbybusinessunits');
    }

    /**
     * Determine whether the settlementByBusinessUnit can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SettlementByBusinessUnit  $model
     * @return mixed
     */
    public function update(User $user, SettlementByBusinessUnit $model)
    {
        return $user->hasPermissionTo('update settlementbybusinessunits');
    }

    /**
     * Determine whether the settlementByBusinessUnit can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SettlementByBusinessUnit  $model
     * @return mixed
     */
    public function delete(User $user, SettlementByBusinessUnit $model)
    {
        return $user->hasPermissionTo('delete settlementbybusinessunits');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SettlementByBusinessUnit  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete settlementbybusinessunits');
    }

    /**
     * Determine whether the settlementByBusinessUnit can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SettlementByBusinessUnit  $model
     * @return mixed
     */
    public function restore(User $user, SettlementByBusinessUnit $model)
    {
        return false;
    }

    /**
     * Determine whether the settlementByBusinessUnit can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SettlementByBusinessUnit  $model
     * @return mixed
     */
    public function forceDelete(User $user, SettlementByBusinessUnit $model)
    {
        return false;
    }
}
