<?php

namespace App\Events;

/**
 * EulaAccepted Event
 *
 * @category   EulaAccepted
 * @package    CoRA-Events
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Eula;
use App\User;

class EulaAccepted
{
    use InteractsWithSockets, SerializesModels;

    public $eula;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Eula $eula, User $user)
    {
        $this->eula = $eula;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
