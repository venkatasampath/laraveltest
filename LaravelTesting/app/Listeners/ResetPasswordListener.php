<?php

namespace App\Listeners;

use App\PasswordHistory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Session;
use Log;

class ResetPasswordListener
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
     * @param  PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        // Special processing for reset password should go here.
        $user = $event->user;
        $passwordHistory = PasswordHistory::create([
            'user_id' => $user->id,
            'password' => $user->password
        ]);

        Log::info(__METHOD__.' - '.$user->org->acronym.':'.$user->name);
    }
}
