<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class ActivateAccount extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'activation.verify', 
            now()->addMinutes(5), 
            ['id' => $notifiable->id]
        );

        return (new MailMessage)
            ->subject('Activate Your Account')
            ->line('Click the button below to activate your account.')
            ->action('Activate Account', $url)
            ->line('This link will expire in 5 minutes.');
    }
}
