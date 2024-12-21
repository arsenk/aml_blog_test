<?php

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Please verify your email address')
            ->line('Thank you for registering with us. Please click the button below to verify your email address.')
            ->action('Verify Email Address', url('email/verify/'.$notifiable->id.'/'.$notifiable->verification_token))
            ->line('If you did not register, no further action is required.');
    }
}
