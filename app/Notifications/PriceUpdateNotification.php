<?php

namespace App\Notifications;

use App\Mail\SendGenericMail;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class PriceUpdateNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;
    public $message;
    public $land;
    public $subject;
    public $body_data;
    public $send_to;
    public $view_file;
    protected $notifiable;

    /**
     * Create a new notification instance.
     */
    public function __construct($message,$url,$land,$subject,$body_data,$view_file ,$send_to)
    {
        $this->message = $message;
        $this->url = $url;
        $this->land = $land;
        $this->subject = $subject;
        $this->body_data = $body_data;
        $this->view_file = $view_file;
        $this->send_to = $send_to;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail','database','broadcast'];

    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->message,
            'url' => $this->url,
        ]);
    }

    public function broadcastAs()
    {
        return 'my-event';
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new SendGenericMail($this->subject, $this->body_data, $this->view_file))
            ->to($this->send_to);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }





}
