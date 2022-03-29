<?php
/*
 * Copyright (c) 2021. Данный файл является интелектуальной собственостью Fulliton.
 * Я буду рад если вы будите вносить улучшения, всегда жду ваших пул реквестов
 */

namespace App\Http\Controllers;


use App\Http\Requests\OrderStoreRequest;
use App\Jobs\CloseOrder;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\AdminPaidOrderNotification;
use App\Notifications\ChangeOrderUser;
use App\Notifications\CreateOrderNotification;
use App\Notifications\RegisterPassword;
use App\Services\CartService;
use App\Services\OrderService;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Swift_TransportException;

class OrderController extends Controller
{

  protected OrderService $orderService;

  public function __construct(OrderService $orderService)
  {
    $this->orderService = $orderService;
  }

  public function index ()
  {
    $orders = auth()->user()->orders()->orderBy('id', 'desc')->get();
    return view('user.order.index', compact('orders'));
  }

  public function create ()
  {
    $cash = Setting::whereName('cash')->first();
    $cloudPayment = Setting::whereName('cloudPayment')->first();
    return view('user.order.create', compact('cash', 'cloudPayment'));
  }

  public function store (OrderStoreRequest $request): JsonResponse
  {
    $data = $request->all();
    $info = $data['info'];
    $user = User::firstOrNew(['email' =>  $info['email']]);

    $user->phone = $info['phone'];
    $user->post_code = $info['post_code'];
    $user->name = $info['name'];
    $user->address = $info['address'];
    $user->phone = $info['phone'];

    if (!$user->created_at) {
      $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
      $password = substr($random, 0, 10);
      $user->password = Hash::make($password);
      try {
        $user->notify(new RegisterPassword($user->email, $password));
      } catch (Swift_TransportException $e) {

      }
    }
    $user->country()->associate($info['country']['id']);
    $user->city()->associate($info['city']['id']);
    $user->save();

    // Временный код пока не подключать Эквайринг
    // TODO: УБрать потом этот код
    $data['method_pay'] = Order::PAYMENT_METHODS_CASH;

    // Конец кода

    $order = $this->orderService
      ->store(
        $user,
        $data['items'],
        $data['method_pay'],
        $data['transfer'],
        $data['price'],
        $data['sale'],
        $data['code']
      );

    $user->notify(new CreateOrderNotification($order));
    Auth::login($user);
    $delay = config('app.order.test') ?
      now()->addMinutes(config('app.order.delay.minutes')) :
      now()->addHours(config('app.order.delay.hours'));
    CloseOrder::dispatch($order, $delay, $this->orderService);

    return response()->json([
      'order' => $order,
      'user' => $user,
      'status' => 'success',
    ]);
  }

  public function updateStatus (Request $request)
  {
    $request->validate([
      'order' => 'required|exists:orders,id'
    ]);

    $order = Order::find($request->order);

    $order->ship_status = Order::SHIP_STATUS_PENDING;
    $order->paid_at = Carbon::now();
    $order->save();
    $order->user->notify(new ChangeOrderUser($order));

    $admins = User::whereIsAdmin(true)->get();

    foreach ($admins as $admin) {
      $admin->notify(new AdminPaidOrderNotification($order));
    }

  }

}
