<?php

/**
 * Cora Base Mail
 *
 * @category   CoraBaseMail
 * @package    CoRA-Mails
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.1
 */

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Log;

class CoraBaseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $server = "ContructorNotCalled";
    public $theUserID = null;
    public $theUser = null;
    public $theOrg = null;
    public $theProject = null;
    public $notification = null;
    public $from_address = "";
    public $from_name = "";
    public $heading = 'No Heading';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification)
    {
        $this->server = config('app.env');
        $this->theUserID = $user_id;
        $this->theUser = User::find($user_id);
        $this->theOrg = $this->theUser->org;
        $this->theProject = $this->theUser->getCurrentProject();
        $this->notification = $notification;
        $this->from_address = config('mail.from.address');
        $this->from_name = config('mail.from.name');
        $this->heading = trans('labels.view_model', ['model'=>'Notification']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->logInfo(__METHOD__,'Should never get here. child class must override build() method');
    }

    protected function logInfo($method, $msg = null)
    {
        if (isset($this->theUser)) {
            Log::info($method ." ". $this->theUser->getLogOrgUserProject() ." ".trim($msg));
        } else {
            Log::info($method . trim($msg));
        }
    }
}
