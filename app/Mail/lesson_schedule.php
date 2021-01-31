<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class lesson_schedule extends Mailable
{
    use Queueable, SerializesModels;

    public $greeting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($greeting)
    {
        $this->greeting = $greeting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.test');
    }
}
