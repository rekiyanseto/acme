<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Survey;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the survey can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list surveys');
    }

    /**
     * Determine whether the survey can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Survey  $model
     * @return mixed
     */
    public function view(User $user, Survey $model)
    {
        return $user->hasPermissionTo('view surveys');
    }

    /**
     * Determine whether the survey can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create surveys');
    }

    /**
     * Determine whether the survey can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Survey  $model
     * @return mixed
     */
    public function update(User $user, Survey $model)
    {
        return $user->hasPermissionTo('update surveys');
    }

    /**
     * Determine whether the survey can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Survey  $model
     * @return mixed
     */
    public function delete(User $user, Survey $model)
    {
        return $user->hasPermissionTo('delete surveys');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Survey  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete surveys');
    }

    /**
     * Determine whether the survey can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Survey  $model
     * @return mixed
     */
    public function restore(User $user, Survey $model)
    {
        return false;
    }

    /**
     * Determine whether the survey can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Survey  $model
     * @return mixed
     */
    public function forceDelete(User $user, Survey $model)
    {
        return false;
    }
}
