<?php
namespace App\Notifications;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends BaseVerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $url = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Verificación de cuenta SIRAE')
            ->view('emails.sirae', [
                'titulo' => 'Verifica tu correo electrónico',
                'mensaje' =>
                'Gracias por registrarte en SIRAE. Para activar tu cuenta confirma tu correo electrónico.',
                'boton' => 'Verificar correo electrónico',
                'url' => $url,
                'url_texto' => 'Si tienes problemas para hacer clic en el botón "Verificar correo electrónico", copia y pega la siguiente URL en tu navegador:',
                'url_respaldo' => $url
            ]);
    }
}