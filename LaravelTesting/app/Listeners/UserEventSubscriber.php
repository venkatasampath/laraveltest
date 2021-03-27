<?php

/**
 * User Event Subscriber
 *
 * @category   UserEventSubscriber
 * @package    CoRA-Subscriber
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Events\ProfileChanged;
use App\Events\ProfilesChanged;
use App\User;
use Log;

/**
 * Class UserEventSubscriber
 * @package App\Listeners
 */
class UserEventSubscriber
{
    /**
     * UserEventSubscriber constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle user login events.
     * @param $event
     */
    public function onUserLogin($event)
    {
        if (Auth::check())
        {
            $user = Auth::user();
            $user_currentproject = Auth::user()->getCurrentProject();
            $user->last_login_ip_address = $this->request->ip();
            $user->last_login_device = $this->request->header('User-Agent');
            $user->save();
            Log::info(__METHOD__.' - ['.$user->org->acronym.':'.$user->name.':'.$user_currentproject->name.'] IP='. $user->last_login_ip_address);
        }
    }

    /**
     * Handle user logout events.
     * @param $event
     */
    public function onUserLogout($event)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user_currentproject = Auth::user()->getCurrentProject();
            Log::info(__METHOD__.' - ['.$user->org->acronym.':'.$user->name.':'.$user_currentproject->name.'] IP='. $user->last_login_ip_address);
        }
    }

    /**
     * Handle the profile change events.
     * This is for single profiles.
     *
     * @param  ProfileChanged  $event
     * @return void
     */
    public function onProfileChange(ProfileChanged $event)
    {
        // Special processing for certain user profile should go here.
        if ($event->profile->name === 'welcome_screen_on_startup') {
            $profile = $event->profile;
            $model = $event->model;

            if ($model->getMorphClass() === 'App\User') {
                Log::info(__METHOD__.' - ProfileName='.$profile->name.' User Id:'.$model->id);
                $this->onProfileChangeForUser($model);
            }
        }
    }

    public function onProfileChangeForUser(User $user) {
        $user->onProfileChange();
    }

    /**
     * Handle the profile change events.
     * This is for multiple profiles. Typically on user of org profiles save.
     *
     * @param  ProfilesChanged  $event
     * @return void
     */
    public function onProfilesChange(ProfilesChanged $event)
    {
        // Special processing for certain user profile should go here.
        $model = $event->model;

        if ($model->getMorphClass() === 'App\User') {
            Log::info(__METHOD__.' (Multiple): User Id:'.$model->id);
            $this->onProfileChangeForUser($model);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param - Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen('Illuminate\Auth\Events\Login', 'App\Listeners\UserEventSubscriber@onUserLogin');
        $events->listen('Illuminate\Auth\Events\Logout', 'App\Listeners\UserEventSubscriber@onUserLogout');

        $events->listen('App\Events\ProfileChanged', 'App\Listeners\UserEventSubscriber@onProfileChange');
        $events->listen('App\Events\ProfilesChanged', 'App\Listeners\UserEventSubscriber@onProfilesChange');
    }
}
