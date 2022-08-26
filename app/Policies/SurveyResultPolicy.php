<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SurveyResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class SurveyResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the surveyResult can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list surveyresults');
    }

    /**
     * Determine whether the surveyResult can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyResult  $model
     * @return mixed
     */
    public function view(User $user, SurveyResult $model)
    {
        return $user->hasPermissionTo('view surveyresults');
    }

    /**
     * Determine whether the surveyResult can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create surveyresults');
    }

    /**
     * Determine whether the surveyResult can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyResult  $model
     * @return mixed
     */
    public function update(User $user, SurveyResult $model)
    {
        return $user->hasPermissionTo('update surveyresults');
    }

    /**
     * Determine whether the surveyResult can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyResult  $model
     * @return mixed
     */
    public function delete(User $user, SurveyResult $model)
    {
        return $user->hasPermissionTo('delete surveyresults');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyResult  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete surveyresults');
    }

    /**
     * Determine whether the surveyResult can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyResult  $model
     * @return mixed
     */
    public function restore(User $user, SurveyResult $model)
    {
        return false;
    }

    /**
     * Determine whether the surveyResult can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SurveyResult  $model
     * @return mixed
     */
    public function forceDelete(User $user, SurveyResult $model)
    {
        return false;
    }
}
