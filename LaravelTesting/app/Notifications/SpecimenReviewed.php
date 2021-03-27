<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use App\SkeletalElement;
use App\User;

class SpecimenReviewed extends CoraBaseNotification
{
    protected $specimen;
    protected $creator;
    protected $reviewer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification_params)
    {
        parent::__construct($user_id, $notification_params);

        $this->specimen = SkeletalElement::find($this->params['specimen_id']);
        $this->creator = User::find($this->params['creator_id']);
        $this->reviewer = User::find($this->params['reviewer_id']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */


    public function toDatabase($notifiable)
    {
        $this->logInfo(__METHOD__,'Preparing database notification entry');

        return [
            'shortMessage' => 'Specimen Reviewed ' . $this->specimen->key,
            'longMessage' => 'The '.$this->specimen->sb->name.' specimen with composite key '.$this->specimen->key.' in project '.$this->specimen->project->name.
                ' created by '.$this->creator->name.' has been reviewed by '.$this->reviewer->name,
            'payload' => $this->specimen
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->logInfo(__METHOD__,'Preparing mail message');

        $url = url('/skeletalelements/'.$this->specimen->id);
        return (new MailMessage)
            ->greeting('Hello '.$this->creator->name)
            ->subject($this->mail_subject.' - Specimen Reviewed')
            ->line('Your '.$this->specimen->sb->name.' specimen with composite key '.$this->specimen->key.' in project '.$this->specimen->project->name.
                ' created by '.$this->creator->name.' has been reviewed by '.$this->reviewer->name)
            ->action('View Specimen', $url)
            ->line($this->mail_thankyou);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        $this->logInfo(__METHOD__,'Preparing slack message');

        $fields = ['Bone'=>$this->specimen->sb->name, 'Side'=>$this->specimen->side,
            'Accession Number'=>$this->specimen->accession_number, 'Provenance1'=>$this->specimen->provenance1,
            'Provenance2'=>$this->specimen->provenance2, 'Designator'=>$this->specimen->designator,
            'Creator'=>$this->creator->name, 'Reviewer'=>$this->reviewer->name];

        $this->logInfo(__METHOD__,json_encode($fields));

        $url = url('/skeletalelements/'.$this->specimen->id);
        return (new SlackMessage)
            ->from($this->slack_from)
            ->to('#general')
            ->content('Specimen in project '.$this->specimen->project->name.' reviewed by '.$this->reviewer->name)
            ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
                $attachment->title('Specimen '.$this->specimen->key, $url)
                    ->fields($fields);
            });

//        return (new SlackMessage)
//            ->from($this->slack_from)
//            ->to($this->theProject->slack_channel)
//            ->content('Specimen in project '.$this->specimen->project->name.' reviewed by '.$this->reviewer->name)
//            ->attachment(function ($attachment) use ($notifiable, $url, $fields) {
//                $attachment->title('Specimen '.$this->specimen->key, $url)
//                    ->fields($fields);
//            });
    }
}
