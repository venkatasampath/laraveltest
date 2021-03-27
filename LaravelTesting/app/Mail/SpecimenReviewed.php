<?php

namespace App\Mail;

use App\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class SpecimenReviewed extends CoraBaseMail
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
    }
}
