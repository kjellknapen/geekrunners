<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WeeklyGoalMail extends Notification
{
    use Notifiable;

    private $email_address;
    private $calcs;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email, $calcs)
    {
        $this->email_address = $email;
        $this->calcs = $calcs;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $goalstocomplete = 0;
        $goalstocomplete += $this->calcs['distance_progress'] < 100 ? 1 : 0;
        $goalstocomplete += $this->calcs['frequency_progress'] < 100 ? 1 : 0;

        return (new MailMessage)
            ->subject("Don't forget to run, you still need to complete " . $goalstocomplete . " goals.")
            ->markdown('mail.goals.send', ['calcs' => $this->calcs]);
    }

    public function routeNotificationForMail()
    {
        return $this->email_address;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
