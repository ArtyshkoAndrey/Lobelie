<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class CreateOrderNotification extends Notification implements ShouldQueue {
  use Queueable;

  protected Order $order;

  public function __construct(Order $order) {
    $this->order = $order;
  }

  public function via($notifiable): array
  {
    return ['mail'];
  }

  public function toMail($notifiable): MailMessage
  {
    return (new MailMessage)
      ->subject('Ваш заказ успешно создан')
      ->greeting('Здраствуйте ' . $this->order->user->name)
      ->line($this->order->created_at->format('d.m.Y H:i') . ' был создан ваш заказ по номеру ' . $this->order->no)
      ->action('Просмотреть статус заказа', route('order.index'))
      ->success();
  }
}
