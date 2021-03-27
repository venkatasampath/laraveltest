<?php

namespace App\Policies;

/**
 * User Policy
 *
 * @category   User
 * @package    CoRA-Policies
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use TCG\Voyager\Policies\BasePolicy;
use Log;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * If you may wish to authorize all actions within a given policy for certain users.
     * The before method will be executed before any other methods on the policy,
     * giving you an opportunity to authorize the action before the intended
     * policy method is actually called. This feature is most commonly used
     * for authorizing application administrators to perform any action.
     *
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the given user can browse the model.
     *
     * @param \App\User $user
     * @param  $model
     *
     * @return bool
     */
    public function browse(User $user)
    {
        return $this->checkPermission($user, new User, 'browse');
    }

    /**
     * Determine if the given model can be viewed by the user.
     *
     * @param \App\User $user
     * @param  $model
     *
     * @return bool
     */
    public function read(User $user, $model)
    {
        if ($this->checkPermission($user, $model, 'read')) {
            // Checks
            // 1. if the given user is reading his own record or
            // 2. The user is the org admin for the org to which this model belongs
            if( $user->id === $model->id ||
                ($user->hasRole('orgadmin') && $user->org->id === $model->org->id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the given model can be edited by the user.
     *
     * @param \App\User $user
     * @param  $model
     *
     * @return bool
     */
    public function edit(User $user, $model)
    {
        if ($this->checkPermission($user, $model, 'edit')) {
            // Checks
            // 1. if the given user is reading his own record or
            // 2. The user has role orgadmin and The user and model belong to the same org
            if( $user->id === $model->id ||
                ($user->hasRole('orgadmin') && $user->org->id === $model->org->id)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine if the given user can create the model.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function add(User $user)
    {
        return $this->checkPermission($user, new User, 'add');
    }

    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param \App\User $user
     * @param  $model
     *
     * @return bool
     */
//    public function delete(TCG\Voyager\Contracts\User $user, $model)
//    {
//        if ($this->checkPermission($user, $model, 'delete')) {
//            // Checks
//            // 1. The user is the org admin for the org to which this model belongs
//            if( $user->hasRole('orgadmin') && $user->org->id === $model->org->id ) {
//                return true;
//            }
//        }
//        return false;
//    }


    /**
     * Determine whether the user can view (multiple profiles) for the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $userRecord
     * @return mixed
     */
    public function showProfiles(User $user, $model)
    {
        Log::info(__METHOD__.' Start: '.$user->id." [".$model->id."]");
        if($user->id === $model->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can updateProfiles (multiple profiles) for the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $userRecord
     * @return mixed
     */
    public function updateProfiles(User $user, $model)
    {
        Log::info(__METHOD__.' Start: '.$user->id." [".$model->id. "]");
        if($user->id === $model->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can updateProfile (single profile) for the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $userRecord
     * @return mixed
     */
    public function updateProfile(User $user, $model)
    {
        Log::info(__METHOD__.' Start: ['.$user->id.":".$model->id."]");
        if($user->id === $model->id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can editOrgProfile for the user.
     *
     * @param  \App\User  $user
     * @param  \App\Org  $orgRecord
     * @return mixed
     */
    public function editOrgProfile(User $user, $model)
    {
        if( $user->hasRole('orgadmin') && $user->org->id === $model->id ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can acceptEula for the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $userRecord
     * @return mixed
     */
    public function acceptEula(User $user, $model)
    {
        if($user->id === $model->id) {
            return true;
        }
        return false;
    }
}

