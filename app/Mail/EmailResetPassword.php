<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailResetPassword extends Mailable
{
  use Queueable, SerializesModels;
  public $data;
  public function __construct($data)
  {
      $this->data = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
      $address = 'e-penda@inotive.id';
      $subject = 'Reset Password';
      $name = "Admin E-Penda";

      return $this->view('emails.resetPassword')
                  ->from($address, $name)
                  ->cc($address, $name)
                  ->bcc($address, $name)
                  ->replyTo($address, $name)
                  ->subject($subject)
                  ->with( $this->data );
  }
}
