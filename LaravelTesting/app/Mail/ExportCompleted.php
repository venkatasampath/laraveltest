<?php

namespace App\Mail;

class ExportCompleted extends CoraBaseMail
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
