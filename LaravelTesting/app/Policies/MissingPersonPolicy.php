<?php

namespace App\Policies;

use App\Isotope;
use App\User;
use App\Dcips;
use Illuminate\Auth\Access\HandlesAuthorization;
use TCG\Voyager\Policies\BasePolicy;

class MissingPersonPolicy extends BasePolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any missingpersons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the missingpersons.
     *
     * @param  \App\User  $user
     * @param  \App\missingpersons  $dcips
     * @return mixed
     */
    public function view(User $user, dcips $dcips)
    {
        //
    }

    /**
     * Determine whether the user can create missingpersons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the missingpersons.
     *
     * @param  \App\User  $user
     * @param  \App\missingpersons  $dcips
     * @return mixed
     */
    public function update(User $user, dcips $dcips)
    {
        //
    }

    /**
     * Determine whether the user can delete the missingpersons.
     *
     * @param  \App\User  $user
     * @param  \App\missingpersons  $dcips
     * @return mixed
     */
    public function delete(User $user, dcips $dcips)
    {
        //
    }

    /**
     * Determine whether the user can restore the missingpersons.
     *
     * @param  \App\User  $user
     * @param  \App\missingpersons  $dcips
     * @return mixed
     */
    public function restore(User $user, dcips $dcips)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the missingpersons.
     *
     * @param  \App\User  $user
     * @param  \App\missingpersons  $dcips
     * @return mixed
     */
    public function forceDelete(User $user, dcips $dcips)
    {
        //
    }

    public function browse(User $user)
    {
        return $this->checkPermission($user, new Dcips, 'browse');
    }
}
