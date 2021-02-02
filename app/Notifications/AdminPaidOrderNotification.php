<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPaidOrderNotification extends Notification
{
  use Queueable;

  protected Order $order;

  /**
   * Create a new notification instance.
   *
   * @param Order $order
   */
  public function __construct(Order $order)
  {
    $this->order = $order;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return MailMessage
   */
  public function toMail($notifiable): MailMessage
  {
    return (new MailMessage)
      ->greeting('Здраствуйте')
      ->subject('Заказ №' . $this->order->no . ' был оплачен')
      ->line('Заказ от '. $this->order->user->name . ' был оплачен. Зайдите в админ панель что бы узать подробнее.')
      ->action('Подробнее', route('admin.order.edit', $this->order->id));
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable): array
  {
    return [
      //
    ];
  }
}
