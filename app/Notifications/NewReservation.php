<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReservation extends Notification
{
    use Queueable;

    public function __construct(public Reservation $reservation) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $listing = $this->reservation->foodListing;

        return (new MailMessage)
            ->subject('Your food is reserved: '.$listing->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($this->reservation->user->name.' reserved '.$this->reservation->quantity.' item(s) of "'.$listing->title.'".')
            ->line('Pickup time: '.$listing->pickup_from->format('d M, H:i').' - '.$listing->pickup_until->format('H:i'))
            ->action('See your pickups', route('pickups.index'))
            ->line('The recipient will show you a pickup code when they come to collect the food.');
    }
}