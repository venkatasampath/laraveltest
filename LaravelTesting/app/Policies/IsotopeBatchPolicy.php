<?php

namespace App\Policies;

/**
 * Isotope Policy
 *
 * @category   Isotope Batch
 * @package    CoRA-Policies
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use App\IsotopeBatch;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;
use TCG\Voyager\Policies\BasePolicy;

class IsotopeBatchPolicy extends BasePolicy
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
        return $this->checkPermission($user, new IsotopeBatch, 'browse');
    }

    /**
     * Determine if the given model can be viewed by the user.
     *
     * @param \App\User $user
     * @param  $model
     *
     * @return bool
     */
    public function read(User $user)
    {
        return $this->checkPermission($user, new IsotopeBatch, 'read');
    }

    /**
     * Determine if the given model can be edited by the user.
     *
     * @param \App\User $user
     * @param  $model
     *
     * @return bool
     */
    public function edit(User $user)
    {
        return $this->checkPermission($user, new IsotopeBatch, 'edit');
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
        return $this->checkPermission($user, new IsotopeBatch, 'add');
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
//            // 1. The user is the org admin for the org to which this model belongs
//            if( $user->isProjectManager($model->project) ||
//                $user->hasRole('orgadmin') && $user->org->id === $model->org->id ) {
//                return true;
//            }
//        }
//        return false;
//    }

}

