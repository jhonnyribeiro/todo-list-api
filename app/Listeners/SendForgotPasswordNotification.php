<?php

namespace App\Listeners;

use App\Events\ForgotPassword;
use App\Mail\ForgotPasswordMail;
use Mail;

class SendForgotPasswordNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param  ForgotPassword  $event
     */
    public function handle(ForgotPassword $event)
    {

        Mail::to($event->user->email)->send(new ForgotPasswordMail($event->user, $event->token));
    }
}
