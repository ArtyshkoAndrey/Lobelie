<?php

namespace App\Jobs;

use App\Notifications\ChangeOrderUser;
use App\Notifications\OrderCancledNotification;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Order;

// Работа когда нужно закрыть заказ, т.е. отмена
class CloseOrder implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected Order $order;
  protected OrderService $orderService;

  public function __construct(Order $order, Carbon $delay, OrderService $orderService)
  {
    $this->order = $order;
    $this->delay($delay);
    $this->orderService = $orderService;
  }

  public function handle()
  {
    if (!isset($this->order->paid_at) && $this->order->ship_status === Order::SHIP_STATUS_PAID) {
      $this->orderService->canceled($this->order);
      $this->order->user->notify(new ChangeOrderUser($this->order));
    }
  }
}
