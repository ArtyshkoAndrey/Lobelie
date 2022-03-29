<?php


namespace App\Services;


use App\Models\CouponCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSkus;
use App\Models\User;
use Carbon\Carbon;

class OrderService
{
  public function store(User $user, array $items, string $method_pay, array $transfer, string $price, string $sale, string $code = null)
  {

    return \DB::transaction(function () use ($user, $items, $method_pay, $transfer, $price, $sale, $code) {

      $order   = new Order([
        'address'      => [
          'address'       => $user->full_Address,
          'contact_name'  => $user->name,
          'contact_phone' => $user->phone,
        ],
        'price' => $price,
        'transfer' => $transfer['name'],
        'payment_method' => $method_pay,
        'ship_price' => $transfer['price'],
        'paid_at' => $method_pay === Order::PAYMENT_METHODS_CASH ? Carbon::now() : null,
        'sale' => $sale,
//        'ship_status' => $method_pay === Order::PAYMENT_METHODS_CARD ? Order::SHIP_STATUS_PAID : Order::SHIP_STATUS_PENDING
        // TODO: Это код который глушит алгорит, пока не подключать Эквайринг
        'ship_status' => Order::SHIP_STATUS_PENDING
      ]);
      $order->user()->associate($user);
      $order->couponCode()->associate(CouponCode::firstWhere('code', $code));
      $order->save();

      foreach ($items as $item) {
        $orderItem = $order->items()->make([
          'price' => $item['on_sale'] ? $item['price_sale'] : $item['price'],
          'amount' => $item['item']['amount']
        ]);
        $ps = ProductSkus::find($item['item']['id']);
        $ps->stock = $ps->stock - $item['item']['amount'];
        $ps->save();
        $orderItem->product()->associate($item['id']);
        $orderItem->skus()->associate($item['skus']['skus']['id']);
        $orderItem->save();

        $pss = ProductSkus::where('product_id', $item['id'])->get();
        if($pss->pluck('stock')->sum() < 1) {
          Product::find($item['id'])->delete();
        }
      }

      return $order;
    });
  }

  public function canceled (Order $order) {
    foreach ($order->items as $orderItem) {
      if(($product = $orderItem->product)->trashed()) {
        $product->restore();
      }
      $ps = ProductSkus::where('product_id', $orderItem->product->id)
        ->where('skus_id', $orderItem->skus->id)
        ->first();
      if($ps) {
        $ps->stock = $ps->stock + $orderItem->amount;
        $ps->save();
      }
    }
    $order->ship_status = Order::SHIP_STATUS_CANCEL;
    $order->save();
  }
}
