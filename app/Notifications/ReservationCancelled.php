<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationCancelled extends Notification implements ShouldQueue
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
            ->subject('Reservation cancelled: '.$listing->title)
            ->greeting('Hello '.$notifiable->name.',')
            ->line($this->reservation->user->name.' cancelled their reservation for "'.$listing->title.'".')
            ->line('Cancelled quantity: '.$this->reservation->quantity.' item(s).')
            ->line('The reserved food quantity is now available again.');
    }
}
