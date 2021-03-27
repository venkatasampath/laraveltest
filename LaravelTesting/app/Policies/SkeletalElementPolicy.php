<?php

namespace App\Policies;

/**
 * SkeletalElement Policy
 *
 * @category   SkeletalElement
 * @package    CoRA-Policies
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\SkeletalElement;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;
use TCG\Voyager\Policies\BasePolicy;

class SkeletalElementPolicy extends BasePolicy
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
        return $this->checkPermission($user, new SkeletalElement, 'browse');
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
            if ($this->isDemoProject($model)) {
                return true;
            }

            // Checks
            // 1. if the given user is assigned to this project or
            // 2. if the model belongs to a project that is public or
            // 3. if the model belongs to a project and the user is part of the project team
            // 4. The user is the org admin for the org to which this model belongs
            if( $user->id === $model->user_id || $model->project->public ||
                $model->project->users->contains($user) ||
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
            if ($this->isDemoProject($model)) {
                return true;
            }

            // Checks
            // 1. if the given user is assigned to this project or
            // 2. if the model belongs to a project and the user is part of the project team
            // 3. The user is the org admin for the org to which this model belongs
            if( $user->id === $model->user_id ||
                $model->project->users->contains($user) ||
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
     * @param \App\Project $project
     *
     * @return bool
     */
    public function add(User $user)
    {
        return $this->checkPermission($user, new SkeletalElement, 'add');
    }

    /**
     * Determine if the given model can be deleted by the user.
     *
     * @param \App\User $user
     * @param  $model
     *
     * @return bool
     */
//    public function delete(User $user, $model)
//    {
//        if ($this->checkPermission($user, $model, 'delete')) {
//            // Checks
//            // 1. if the given user is assigned to this project or
//            // 2. The user is the org admin for the org to which this model belongs
//            if( $user->id === $model->user_id ||
//                $user->isProjectManager($model->project) ||
//                ($user->hasRole('orgadmin') && $user->org->id === $model->org->id)) {
//                return true;
//            }
//        }
//        return false;
//    }

    protected function isDemoProject($model)
    {
        return ($model->project->name === "CoRA Demo") ? true : false;
    }
}
