<?php

/**
 * Cora Base Notification
 *
 * @category   CoraBaseNotification
 * @package    CoRA-Notifications
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.1
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Log;

/**
 * Class CoraBaseNotification
 * @package App\Notifications
 */
class CoraBaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $server = "ContructorNotCalled";
    protected $theUserID = null;
    protected $theUser = null;
    protected $theOrg = null;
    protected $theProject = null;
    protected $params = null;

    protected $mail_subject = "CoRA Notification";
    protected $mail_thankyou = "Thank you for using the CoRA application!";
    protected $slack_from = "CoRA";
    protected $slack_icon = "";
    protected $slack_channel = "#general";
    protected $via = ['database'];

    /**
     * set this flag to indicate that this notification is for a job.
     *
     * @var bool
     */
    protected $isJob = false;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification_params)
    {
        $this->theUserID = $user_id;
        $this->theUser = User::find($user_id);
        $this->theOrg = $this->theUser->org;
        $this->theProject = $this->theUser->getCurrentProject();
        $this->params = $notification_params;

        $this->server = config('app.env');
        $this->slack_from = $this->slack_from .": ".$this->server;
//        $isJob = isset($this->params['is_job']) && $this->params['is_job'] ? true:false;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        $notifiable->getProfileValue('notify_via_email') ? array_push($this->via, 'mail') : $this->via;
          $notifiable->getProfileValue('notify_via_slack') ? array_push($this->via, 'slack') : $this->via;
//        $notifiable->getProfileValue('notify_via_sms') ? array_push($this->via, 'nexmo') : $this->via;

        $this->logInfo(__METHOD__, json_encode($this->via));
        return $this->via;
    }

    /**
     * @param $method
     * @param null $msg
     */
    protected function logInfo($method, $msg = null)
    {
        if (isset($this->theUser)) {
            Log::info($method ." ". $this->theUser->getLogOrgUserProject() ." ".trim($msg));
        } else {
            Log::info($method . trim($msg));
        }
    }
}