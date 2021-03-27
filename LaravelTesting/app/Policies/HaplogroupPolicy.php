<?php

namespace App\Policies;

/**
 * Haplogroup Policy
 *
 * @category   Haplogroup
 * @package    CoRA-Policies
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\Haplogroup;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use TCG\Voyager\Policies\BasePolicy;

class HaplogroupPolicy extends BasePolicy
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
        if ( $user->isAdmin()) {
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
        // Checks
        // 1. The user role has browse permission for Haplogroups.
        // 2. The user is the Project Manager for the Project.
        if (($this->checkPermission($user, new Haplogroup, 'browse')) ||
            $user->isProjectManager()) {
                return true;
        }
        return false;
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
        // Checks
        // 1. The user role has browse permission for Haplogroups.
        // 2. The user is the Project Manager for the Project.
        if (($this->checkPermission($user, new Haplogroup, 'browse')) ||
            $user->isProjectManager()) {
            return true;
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
        // Checks
        // 1. The user role has browse permission for Haplogroups.
        // 2. The user is the Project Manager for the Project.
        if (($this->checkPermission($user, new Haplogroup, 'browse')) ||
            $user->isProjectManager()) {
            return true;
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
        // Checks
        // 1. The user role has browse permission for Haplogroups.
        // 2. The user is the Project Manager for the Project.
        if (($this->checkPermission($user, new Haplogroup, 'browse')) ||
            $user->isProjectManager()) {
            return true;
        }
        return false;
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
//        // Checks
//        // 1. The user role has browse permission for Haplogroups.
//        // 2. The user is the Project Manager for the Project.
//        if (($this->checkPermission($user, new Haplogroup, 'browse')) ||
//            $user->isProjectManager()) {
//            return true;
//        }
//        return false;
//    }
}
