<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserOrder extends Mailable
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
          
        if(session('locale')=='en'){
            $lang = 'en-SA/Mail/user_order';
        }
        else{
            $lang = 'ar-SA/Mail/user_order';
        }

        $e_subject = $this->sub;
        $orderDetails = $this->orderDetails;
        $cartItemArray = $this->cartItems;
        
                       dd($cartItemArray);

        return $this
         ->from($address = 'cureroot@gmail.com', $name = 'Cureroot')
        ->subject($e_subject)
        ->view($lang,compact('orderDetails','cartItemArray'));
        
    }
}
