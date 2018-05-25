<?php

namespace App\Notifications\Fleet;

use App\Character;
use App\Fleet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public $fleet;
    public $editor;

    /**
     * Create a new notification instance.
     *
     * @param Fleet $fleet
     * @param Character $editor
     *
     * @return void
     */
    public function __construct(Fleet $fleet, Character $editor)
    {
        $this->fleet = $fleet;
        $this->editor = $editor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = ['broadcast', 'database'];

        if (isset($notifiable->email)) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("{$this->editor->name} has updated the {$this->fleet->title} fleets status.")
                    ->action('View Fleet', url('/fleets/'.$this->fleet->id));
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
            'fleet_id' => $this->fleet->id,
            'fleet_name' => $this->fleet->title,
            'editor_id' => $this->editor->id,
            'editor_name' => $this->editor->name,
            'new_status' => $this->fleet->status,
        ];
    }
}
