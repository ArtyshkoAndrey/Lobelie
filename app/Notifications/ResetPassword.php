<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPasswordNotification
{
  /**
   * Get the reset password notification mail message for the given URL.
   *
   * @param  string  $url
   * @return MailMessage
   */
  protected function buildMailMessage($url): MailMessage
  {
    return (new MailMessage)
      ->subject('Востановление пароля')
      ->line('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.')
      ->action('Сбросить пароль', $url)
      ->line('Срок действия ссылки для сброса пароля истечет через 60 минут')
      ->line('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.')
      ->greeting('Здраствуйте');
  }
}
