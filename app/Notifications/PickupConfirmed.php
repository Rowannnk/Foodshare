<?php

namespace App\Notifications;

use App\Models\Pickup;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PickupConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Pickup $pickup) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $listing = $this->pickup->reservation->foodListing;

        return (new MailMessage)
            ->subject('Pickup confirmed: '.$listing->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($listing->organization->name.' confirmed that you collected "'.$listing->title.'".')
            ->line('Thank you for helping to reduce food waste!')
            ->action('See your reservations', route('reservations.index'));
    }
}