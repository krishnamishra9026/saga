<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $EmailData)
    {
        
          $this->sub = $subject;
        $this->emailData = $EmailData;
        
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if(session('locale')=='en'){
            $lang = 'en-SA/Mail/user_registration';
        }
        else{
            $lang = 'ar-SA/Mail/user_registration';
        }

        // echo $lang;
        // die();
       
        $e_subject = $this->sub;
        $EmailData = $this->emailData;
       
    //   dd($EmailData);
        return $this
        ->subject($e_subject)
        ->view($lang,compact('EmailData'));
    }
}
