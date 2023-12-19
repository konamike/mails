<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\File;

class FileReceivedNotification extends Notification
{
    use Queueable;
    private $filereceived;

    /**
     * Create a new notification instance.
     */
    public function __construct($filereceived)
    {
        $this->filereceived = $filereceived;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->filereceived['user_id'],
            'dispatch_email' => $this->filereceived['dispatch_email'],
            'date_dispatched' => $this->filereceived['date_dispatched'],
            'description' => $this->filereceived['description']
        ];
    }
}
