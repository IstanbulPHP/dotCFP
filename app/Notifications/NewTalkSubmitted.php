<?php

namespace App\Notifications;

use App\Talk;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewTalkSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Talk
     */
    private $talk;
    
    /**
     * Create a new notification instance.
     *
     * @param Talk $talk
     */
    public function __construct(Talk $talk)
    {
        $this->talk = $talk;
    }
    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $eventName = config('dotcfp.event_name');
        
        return (new MailMessage)
            ->subject("New Submission For $eventName")
            ->line("A new talk has been submitted to $eventName.")
            ->line("Title: {$this->talk->title}")
            ->line("Description: {$this->talk->description}")
            ->action('View', route('talks.show', $this->talk->slug));
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
