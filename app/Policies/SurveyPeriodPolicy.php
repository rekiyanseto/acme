<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SurveyPeriod;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyPeriodPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the surveyPeriod can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list surveyperiods');
    }

    /**
     * Determine whether the surveyPeriod can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyPeriod  $model
     * @return mixed
     */
    public function view(User $user, SurveyPeriod $model)
    {
        return $user->hasPermissionTo('view surveyperiods');
    }

    /**
     * Determine whether the surveyPeriod can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create surveyperiods');
    }

    /**
     * Determine whether the surveyPeriod can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyPeriod  $model
     * @return mixed
     */
    public function update(User $user, SurveyPeriod $model)
    {
        return $user->hasPermissionTo('update surveyperiods');
    }

    /**
     * Determine whether the surveyPeriod can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyPeriod  $model
     * @return mixed
     */
    public function delete(User $user, SurveyPeriod $model)
    {
        return $user->hasPermissionTo('delete surveyperiods');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyPeriod  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete surveyperiods');
    }

    /**
     * Determine whether the surveyPeriod can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyPeriod  $model
     * @return mixed
     */
    public function restore(User $user, SurveyPeriod $model)
    {
        return false;
    }

    /**
     * Determine whether the surveyPeriod can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyPeriod  $model
     * @return mixed
     */
    public function forceDelete(User $user, SurveyPeriod $model)
    {
        return false;
    }
}
