<?php

namespace App\Notifications;

use App\Models\Comentario;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ComentarioNotificado extends Notification
{
    use Queueable;

    protected $comentario;

    public function __construct(Comentario $comentario)
    {
        $this->comentario = $comentario;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Tienes un nuevo comentario en tu publicación.')
            ->action('Ver Publicación', url('/publicaciones/' . $this->comentario->publicacion_id))
            ->line('Gracias por usar nuestra aplicación!');
    }

    public function toArray($notifiable)
    {
        return [
            'comentario_id' => $this->comentario->id,
            'publicacion_id' => $this->comentario->publicacion_id,
        ];
    }
}
