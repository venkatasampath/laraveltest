<?php

/**
 * Eulas Trait
 *
 * @category   Eulas
 * @package    CoRA-Traits
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Http\Traits;

use App\Eula;
use Auth;
use Log;

trait EulasTrait
{
    /**
     * Indicates that this Model (typically user) should perform Eula processing
     *
     * @var bool
     */
    public $eulaProcessing = false;

    /**
     * Indicates the this Model (typically user) has already accepted the eula
     *
     * @var bool
     */
    public $eulaAccepted = false;

    /**
     * The eula Model accepted by the user
     *
     * @var mixed (Model)
     */
    public $userAcceptedEula = null;

    /**
     * Get all of the eulas for this User Model.
     *
     * @return mixed
     */
    public function eulas()
    {
        return $this->belongsToMany('App\Eula', 'eula_user', 'user_id', 'eula_id')
            ->withPivot('user_id', 'eula_id', 'signature', 'accepted_at', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get the latest accepted eula for this user.
     *
     * @return mixed
     */
    public function getActiveEula()
    {
        return $this->eulas()->orderBy('pivot_accepted_at', 'desc')->get()->first();
    }

    /**
     * The checkEula function sets the eulaProcessing and eulaAccepted flags for this user.
     * This function is called to check if Eula processing is required for this user
     * once the user logs into the system.
     *
     * @return bool
     */
    public function checkEula()
    {
        if ($this->org->getProfileValue('eula_processing')) {
            $this->eulaProcessing = true;
            $orgEula = $this->org->getActiveEulaForUser($this);
            $currentlyAcceptedEula = $this->getActiveEula();

            if (!isset($currentlyAcceptedEula) || !isset($orgEula)) {
                //            dd(['true',$orgEula, $currentlyAcceptedEula, $this]);
                return ($this->eulaAccepted = false);
            } else if ($orgEula->id != $currentlyAcceptedEula->id) {
                return ($this->eulaAccepted = false);
            } else {
                return ($this->eulaAccepted = true);
            }
        } else {
            $this->eulaProcessing = false;
        }
    }
}