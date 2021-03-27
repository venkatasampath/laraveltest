<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Carbon\Carbon;

class SpecimenGroupCreated extends CoraBaseNotification
{
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification_params)
    {
        parent::__construct($user_id, $notification_params);

        $this->isJob = true;
    }

    /**
     * Get the database representation of the notification.
     *
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $this->logInfo(__METHOD__,'Preparing database notification entry - '.$this->params['hasJobFailed'] ? "true":"false");

        $arr = ['bone_group_id'=>$this->params['bone_group_id'], 'boneGroupName'=>$this->params['boneGroupName'], 'boneGroupCount'=>$this->params['boneGroupCount'],
            'job_timestamp'=>$this->params['job_timestamp'], 'an'=>$this->params['an'], 'p1'=>$this->params['p1'], 'p2'=>$this->params['p2'], 'de'=>$this->params['de']];

        $this->logInfo(__METHOD__,json_encode($arr));
        if($this->params['hasJobFailed']) {
            return $arr + ['shortMessage' => 'Specimen Group ['.$this->params['boneGroupName'].'] creation has failed',
                'longMessage' => 'Your Specimen Group Creation of '.$this->params['boneGroupName'].' with '.$this->params['boneGroupCount'].' bones in project '.$this->theProject->name.' has failed, having '.
                    'Accession Number: '.$this->params['an'].', Provenance1: '.$this->params['p1'].', Provenance2: '.$this->params['p2'].', Starting Designator: '.$this->params['de']];
        } else {
            return $arr + ['shortMessage' => 'Specimen Group ['.$this->params['boneGroupName'] . '] creation has succeeded',
                'longMessage' => 'Your Specimen Group Creation of '.$this->params['boneGroupName'].' with '.$this->params['boneGroupCount'].' bones in project '.$this->theProject->name.' has succeeded, having '.
                    'Accession Number: '.$this->params['an'].', Provenance1: '.$this->params['p1'].', Provenance2: '.$this->params['p2'].', Starting Designator: '.$this->params['de']];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if($this->params['hasJobFailed']) {
            $this->logInfo(__METHOD__, 'Preparing email for failure');

            $url = url('/skeletalelements/createbygroup');
            return (new MailMessage)
                ->greeting('Hello '.$notifiable->name)
                ->error()
                ->subject($this->mail_subject.' - Specimen Group creation failed')
                ->line('Your group Specimen Creation of '.$this->params['boneGroupName'].' in project '.$this->theProject->name.' has failed')
                ->line('You can try again using the link below')
                ->action('Try Again', $url)
                ->line($this->mail_thankyou);
        } else {
            $this->logInfo(__METHOD__,'Preparing mail message for success');

            $url = url('/reports/bonegroup/' . $this->params['bone_group_id']);
            return (new MailMessage)
                ->greeting('Hello '.$notifiable->name)
                ->success()
                ->subject($this->mail_subject.' - Specimen Group creation succeeded')
                ->line('Your Specimen Group Creation of '.$this->params['boneGroupName'].' in project '.$this->theProject->name.' has successfully completed')
                ->action('View Specimen Group', $url)
                ->line($this->mail_thankyou);
        }
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $this->logInfo(__METHOD__,'Preparing slack message - '.$this->params['hasJobFailed'] ? "true":"false");

        $fields = [ 'Accession Number'=>$this->params['an'], 'Provenance1'=>$this->params['p1'],
                    'Provenance2'=>$this->params['p2'], 'Starting Designator'=>$this->params['de'],
                    'Created At'=> $this->params['job_timestamp']->format('m-d-Y H:i T'), 'Specimen Count'=>$this->params['boneGroupCount']];

        $this->logInfo(__METHOD__,json_encode($fields));
        if($this->params['hasJobFailed']) {
            $this->logInfo(__METHOD__,'Preparing slack message for failure');
            $url = url('/skeletalelements/createbygroup');
            return (new SlackMessage)
                ->from($this->slack_from)
                ->to('#general')
                ->content('Whoops! Specimen group creation failed in project '.$this->theProject->name.' by '.$notifiable->name)
                ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
                    $attachment->fields($fields)
                        ->title('Create Specimen Group', $url);
                });
        } else {
            $this->logInfo(__METHOD__,'Preparing slack message for success');
            $url = url('/reports/bonegroup/'.$this->params['bone_group_id']);
            return (new SlackMessage)
                ->from($this->slack_from)
                ->to('#general')
                ->content('Success! Specimen group created in project '.$this->theProject->name.' by '.$notifiable->name)
                ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
                    $attachment->title('Specimen group ['. $this->params['boneGroupName'] . '] created', $url)
                        ->fields($fields);
                });
        }
    }
}