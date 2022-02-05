<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$orderDetails,$cartItemArray)
    {
        $this->sub = $subject;
        $this->orderDetails = $orderDetails;
        $this->cartItems = $cartItemArray;

        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $e_subject = $this->sub;
        $orderDetails = $this->orderDetails;
        $cartItemArray = $this->cartItems;
        
        return $this
         ->from($address = 'cureroot@gmail.com', $name = 'Cureroot')
        ->subject($e_subject)
        ->view('Mail.admin_order_mail',compact('orderDetails','cartItemArray'));
    }
}
