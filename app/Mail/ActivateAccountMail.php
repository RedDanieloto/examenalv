<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ActivateAccount extends Notification
{
    protected $activationUrl;

    public function __construct($activationUrl)
    {
        $this->activationUrl = $activationUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Activate Your Account')
                    ->line('Click the button below to activate your account.')
                    ->action('Activate Account', $this->activationUrl)
                    ->line('Thank you for using our application!');
    }
}
