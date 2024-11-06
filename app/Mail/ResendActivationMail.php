<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class ResendActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $url = URL::temporarySignedRoute(
            'activation.verify',
            now()->addMinutes(5),
            ['id' => $this->user->id]
        );

        return $this->subject('Activate Your Account')
            ->view('emails.resend_activation')
            ->with([
                'name' => $this->user->name,
                'activationUrl' => $url,
            ]);
    }
}
