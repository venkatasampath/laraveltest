<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class ExportCompleted extends CoraBaseNotification
{
    protected $exportType;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification_params)
    {
        parent::__construct($user_id, $notification_params);

        $this->exportType = $this->params['payload'];
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

        $arr = ['payload' => $this->params['payload'], 'is_job'=>$this->params['is_job'], 'job_timestamp'=>$this->params['job_timestamp']];

        $this->logInfo(__METHOD__,json_encode($arr));
        if($this->params['hasJobFailed']) {
            return $arr + ['shortMessage' => 'Export '.$this->exportType->name.' failed',
                    'longMessage' => 'Your export of '.$this->exportType->name.' has failed, in project '.$this->theProject->name.' by '.$notifiable->name];
        } else {
            return $arr + ['shortMessage' => 'Export '.$this->exportType->name.' succeeded',
                    'longMessage' => 'Your export of '.$this->exportType->name.' has succeeded, in project '.$this->theProject->name.' by '.$notifiable->name];
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
            $this->logInfo(__METHOD__,'Preparing email for failure');

            $url = url('/exportOptions');
            return (new MailMessage)
                ->greeting('Hello '.$notifiable->name)
                ->error()
                ->subject($this->mail_subject.' - Export failed')
                ->line('Your export of '.$this->exportType->name.' has failed, in project '.$this->theProject->name.' by '.$notifiable->name)
                ->line('You can try again using the link below')
                ->action('Try Again', $url)
                ->line($this->mail_thankyou);
        } else {
            $this->logInfo(__METHOD__,'Preparing mail message for success');

            $url = url('/exportFileManager');
            return (new MailMessage)
                ->greeting('Hello '.$notifiable->name)
                ->success()
                ->subject($this->mail_subject.' - Export succeeded')
                ->line('Your export of '.$this->exportType->name.' has succeeded, in project '.$this->theProject->name.' by '.$notifiable->name)
                ->action('View Exported Files', $url)
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

        $fields = [ 'Export Type'=>$this->exportType->name, 'Created At'=> $this->params['job_timestamp']->format('m-d-Y H:i T')];

        $this->logInfo(__METHOD__,json_encode($fields));
        if($this->params['hasJobFailed']) {
            $this->logInfo(__METHOD__,'Preparing slack message for failure');
            $url = url('/exportOptions');
            return (new SlackMessage)
                ->from($this->slack_from)
                ->to('#general')
                ->content('Whoops! Export '.$this->exportType->name.' failed in project '.$this->theProject->name.' by '.$notifiable->name)
                ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
                    $attachment->fields($fields)
                        ->title('Create New Export', $url);
                });
        } else {
            $this->logInfo(__METHOD__,'Preparing slack message for success');
            $url = url('/exportFileManager');
            return (new SlackMessage)
                ->from($this->slack_from)
                ->to('#general')
                ->content('Success! Export '.$this->exportType->name.' completed in project '.$this->theProject->name.' by '.$notifiable->name)
                ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
                    $attachment->title('Download Export', $url)
                        ->fields($fields);
                });
        }
    }
}
