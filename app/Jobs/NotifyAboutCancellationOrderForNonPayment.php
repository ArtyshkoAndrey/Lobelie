<?php

namespace App\Jobs;

use App\Models\Order;
use App\Notifications\ChangeOrderUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Swift_TransportException;

/**
* Class NotifyAboutCancellationOrderForNonPayment. Уведомить пользователя об автоотмене заказ если так и не оплатил
* @package App\Jobs
*/
class NotifyAboutCancellationOrderForNonPayment implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected Order $order;

  /**
   * Создание job, закидываем заказ в работу.
   *
   * @param Order $order
   */
  public function __construct(Order $order)
  {
    $this->order = $order;
    $this->delay(now()->addHours(config('app.order.delay.hours')));
  }

  /**
   * Выполнение само работы.
   *
   * @return void
   */
  public function handle()
  {
    if (!$this->order->paid_at) {
      $this->order->close();
      try {
        $this->order->user()->notify(new ChangeOrderUser($this->order));
      } catch (Swift_TransportException $exception) {

      }

    }
  }
}
