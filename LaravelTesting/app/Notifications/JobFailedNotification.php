<?php

/**
 * Job Failed Notification
 *
 * @category   JobFailedNotification
 * @package    CoRA-Notifications
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.1
 */

namespace App\Notifications;

use Illuminate\Notifications\Messages\SlackMessage;

/**
 * If a job fails, you’d probably want to know about it immediately.
 * CoRA application will slack the operation team when something
 * fails so they can check it out.
 *
 * Class JobFailedNotification
 * @package App\Notifications
 */
class JobFailedNotification extends CoraBaseNotification
{
    /**
     * @var $event
     */
    private $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $event)
    {
        parent::__construct($user_id);
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels. We are over writing the parent via
     * as we only want to send this to the operations team via slack channel
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $this->logInfo(__METHOD__.' Preparing Slack message');
        return (new SlackMessage)
            ->from($this->from)
            ->to('#general')
            ->error()
            ->content('Queued job failed: ' . $this->event['job'])
            ->attachment(function ($attachment) {
                $attachment->title($this->event['exception']['message'])
                    ->fields([
                        'ID' => $this->event['id'],
                        'Name' => $this->event['name'],
                        'File' => $this->event['exception']['file'],
                        'Line' => $this->event['exception']['line'],
                        'Server' => env('APP_ENV'),
                        'Queue' => $this->event['queue'],
                ]);
            });
    }
}