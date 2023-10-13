<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user = '';
    public $verify_token = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$verify_token)
    {
        $this->user = $user;
        $this->verify_token = $verify_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgetPassword');
    }
}
