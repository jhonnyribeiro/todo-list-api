<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public User $user;
    public string $token;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  string  $token
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.forgot_password')
            ->subject('Alteração de senha')
            ->with([
                'resetPasswordLink' => config('app.url').'/recuperar-senha?token='.$this->token,
            ]);
    }
}
