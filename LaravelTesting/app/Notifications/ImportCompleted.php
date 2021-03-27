<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class ImportCompleted extends CoraBaseNotification
{
    protected $importType;
    protected $fileName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification_params)
    {
        parent::__construct($user_id, $notification_params);

        $this->importType = $this->params['payload'];
        $this->fileName = $this->params['fileName'];
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
            return $arr + ['shortMessage' => 'Import '.$this->importType->display_name.' failed',
                    'longMessage' => 'Your import of '.$this->importType->display_name.' has failed, in project '.$this->theProject->name.' by '.$notifiable->name];
        } else {
            return $arr + ['shortMessage' => 'Import '.$this->importType->display_name.' succeeded',
                    'longMessage' => 'Your import of '.$this->importType->display_name.' has succeeded, in project '.$this->theProject->name.' by '.$notifiable->name];
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

            $url = url('/importFile');
            return (new MailMessage)
                ->greeting('Hello '.$notifiable->name)
                ->error()
                ->subject($this->mail_subject.' - Import failed')
                ->line('Your import of '.$this->importType->display_name.' using the file '.$this->fileName.' has failed, in project '.$this->theProject->name.' by '.$notifiable->name)
                ->line('You can try again using the link below')
                ->action('Try Again', $url)
                ->line($this->mail_thankyou);
        } else {
            $this->logInfo(__METHOD__,'Preparing mail message for success');

            $url = url('/dashboard');
            return (new MailMessage)
                ->greeting('Hello '.$notifiable->name)
                ->success()
                ->subject($this->mail_subject.' - Import succeeded')
                ->line('Your import of '.$this->importType->display_name.' using the file '.$this->fileName.' has succeeded, in project '.$this->theProject->name.' by '.$notifiable->name)
                ->action('View Imported Records', $url)
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

        $fields = [ 'Import Type'=>$this->importType->display_name, 'Created At'=> $this->params['job_timestamp']->format('m-d-Y H:i T'), 'Using File' => $this->fileName ];

        $this->logInfo(__METHOD__,json_encode($fields));
        if($this->params['hasJobFailed']) {
            $this->logInfo(__METHOD__,'Preparing slack message for failure');
            $url = url('/importFile');
            return (new SlackMessage)
                ->from($this->slack_from)
                ->to('#general')
                ->content('Whoops! Import '.$this->importType->display_name.' using the file '.$this->fileName.' has failed, in project '.$this->theProject->name.' by '.$notifiable->name)
                ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
                    $attachment->fields($fields)
                        ->title('Create New Import', $url);
                });
        } else {
            $this->logInfo(__METHOD__,'Preparing slack message for success');
            $url = url('/dashboard');
            return (new SlackMessage)
                ->from($this->slack_from)
                ->to('#general')
                ->content('Success! Import '.$this->importType->display_name.' using the file '.$this->fileName.' has succeeded, in project '.$this->theProject->name.' by '.$notifiable->name)
                ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
                    $attachment->title('Go to Dashboard', $url)
                        ->fields($fields);
                });
        }
    }
}
