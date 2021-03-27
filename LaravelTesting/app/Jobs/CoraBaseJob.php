<?php

/**
 * Cora Base Job
 *
 * @category   CoraBaseJob
 * @package    CoRA-Jobs
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2019
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.1
 */

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use Log;

class CoraBaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    protected $server = "ContructorNotCalled";
    protected $theUserID = null;
    protected $theUser = null;
    protected $theOrg = null;
    protected $theProject = null;
    protected $notification_params = null;
    protected $request = null;

    public function __construct($user_id)
    {
        $this->server = config('app.env');
        $this->theUserID = $user_id;
        $this->theUser = User::find($user_id);
        $this->theOrg = $this->theUser->org;
        $this->theProject = $this->theUser->getCurrentProject();
        $this->notification_params = array('job_timestamp'=>Carbon::now(), 'is_job'=>true, 'hasJobFailed'=>false);
    }

    public function handle()
    {
        Log::info(__METHOD__.' Should never get here. child class must override handle() method');
    }

    /**
     * The job failed to process.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        Log::info(__METHOD__.' Should never get here. child class must override failed() method');
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