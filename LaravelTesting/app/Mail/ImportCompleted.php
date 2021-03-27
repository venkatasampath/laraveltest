<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportCompleted extends CoraBaseMail
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $notification)
    {
        parent::__construct($user_id, $notification);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->from_address)
            ->view('notifications.show');

//        $notificationData = $this->notification->data;
//        return $this->view('notifications.show')
//            ->with([
//                'importType' => $notificationData['payload']['display_name'],
//                'createdAt' => $this->notification->created_at,
//                'notification' => $this->notification,
//                'user' => $this->user
//            ]);
    }
}
