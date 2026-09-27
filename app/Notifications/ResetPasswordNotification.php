<?php
namespace App\Notifications;
use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends BaseResetPassword
{
    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
        return (new MailMessage)
            ->subject('Restablecer contraseña SIRAE')
            ->view('emails.sirae', [
                'titulo' => 'Restablecer contraseña',
                'mensaje' =>
                'Recibimos una solicitud para restablecer la contraseña de tu cuenta SIRAE.',
                'boton' => 'Cambiar contraseña',
                'url' => $url,
                'url_texto' =>
                'Si tienes problemas para hacer clic en el botón "Cambiar contraseña", copia y pega la siguiente URL en tu navegador:',
                'url_respaldo' => $url
            ]);
    }
}