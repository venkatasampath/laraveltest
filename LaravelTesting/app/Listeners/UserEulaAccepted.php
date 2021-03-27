<?php

namespace App\Listeners;

use App\Events\EulaAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Session;
use Log;

class UserEulaAccepted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EulaAccepted  $event
     * @return void
     */
    public function handle(EulaAccepted $event)
    {
        // Special processing for user eula acceptance should go here.
        $eula = $event->eula;
        $user = $event->user;

        Log::info(__METHOD__.' Listener: '.$user->org->acronym.':'.$user->name.' Eula Id:'.$eula->id);
        $user->initialize();
    }
}
