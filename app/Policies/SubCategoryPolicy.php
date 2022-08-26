<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SubCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the subCategory can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list subcategories');
    }

    /**
     * Determine whether the subCategory can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubCategory  $model
     * @return mixed
     */
    public function view(User $user, SubCategory $model)
    {
        return $user->hasPermissionTo('view subcategories');
    }

    /**
     * Determine whether the subCategory can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create subcategories');
    }

    /**
     * Determine whether the subCategory can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubCategory  $model
     * @return mixed
     */
    public function update(User $user, SubCategory $model)
    {
        return $user->hasPermissionTo('update subcategories');
    }

    /**
     * Determine whether the subCategory can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubCategory  $model
     * @return mixed
     */
    public function delete(User $user, SubCategory $model)
    {
        return $user->hasPermissionTo('delete subcategories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubCategory  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete subcategories');
    }

    /**
     * Determine whether the subCategory can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubCategory  $model
     * @return mixed
     */
    public function restore(User $user, SubCategory $model)
    {
        return false;
    }

    /**
     * Determine whether the subCategory can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\SubCategory  $model
     * @return mixed
     */
    public function forceDelete(User $user, SubCategory $model)
    {
        return false;
    }
}
