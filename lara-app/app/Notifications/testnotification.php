<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class testnotification extends Notification
{
    use Queueable;
    private $name;
    private $date;
    private $phone;
    private $time;
    private $totalperson;

    /**
     * Create a new notification instance.
     */
    public function __construct($name, $date, $time, $phone, $totalperson)
    {
        $this->name = $name;
        $this->date = $date;
        $this->time = $time;
        $this->phone = $phone;
        $this->totalperson = $totalperson;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "name" => $this -> name,
            "date" => $this -> date,
            "time" => $this -> time,
            "phone" => $this -> phone,
            "totalperson" => $this -> totalperson,

        ];
    }
}
