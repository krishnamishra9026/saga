<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $EmailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
      public function __construct($EmailData)
    {
        $this->EmailData = $EmailData;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->subject('Mail from Cure root Department')
                    ->view('Front.user-registration');
    }
}
