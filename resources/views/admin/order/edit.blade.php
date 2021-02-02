@extends('admin.layouts.app')

@section('title', 'Doscu - Список заказов')

@section('content')
    <div class="container-fluid mt-20 mb-20">
      <div class="row row-eq-spacing">
        <div class="col-12">
          <nav aria-label="Breadcrumb navigation example">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('admin.order.index') }}">Заказы</a></li>
              <li class="breadcrumb-item active">Редактирование заказа №{{ $order->no }}</li>
            </ul>
          </nav>
        </div>
        <div class="col-12">
          <h3>Редактирование заказа</h3>
        </div>

        <div class="col-lg-4 col-12 mt-10">
          <div class="row">

            <div class="col-12 mt-10">
              <div class="card p-0 m-0 bg-dark-dm">
                <div class="row p-20">
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Номер заказа:</span> {{ $order->no }}</p >
                  </div>
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Покупатель:</span> {{ $order->user->name }}</p >
                  </div>
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Дата покупки:</span> {{ $order->created_at->format('d.m.Y') }}</p >
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 mt-10">
              <div class="card p-0 m-0 bg-dark-dm">
                <div class="row p-20">
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Адрес доставки:</span> {{ $order->address->address }}</p >
                  </div>
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Имя получателя:</span> {{ $order->address->contact_name }}</p >
                  </div>

                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Телефон:</span> {{ $order->user->phone }}</p >
                  </div>

                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Email:</span> <a href="mailto:{{ $order->user->email }}" class="text-danger">{{ $order->user->email }}</a></p >
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 mt-10">
              <div class="card p-0 m-0 bg-dark-dm">
                <div class="row p-20">
                  <div class="col-12">
{{--                    TODO: переделать вывод выбраной компании, хранить имя в бд --}}
                    <p class="m-0"><span class="font-weight-bold">Доставка:</span> {{ \App\Models\Order::$transferMethodsMap[$order->transfer] }}</p>
                  </div>
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Оплата:</span> {{ \App\Models\Order::$paymentMethodsMap[$order->payment_method] }}</p >
                  </div>
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Стоимость доставки:</span> {{ number_format($order->ship_price, 0,',', ' ') }} ₸</p >
                  </div>
                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Скидка:</span> {{ number_format($order->sale, 0,',', ' ') }} ₸</p >
                  </div>
                  @if($order->couponCode)
                    <div class="col-12">
                      <p class="m-0"><span class="font-weight-bold">Промокод:</span> {{ $order->couponCode->code }}</p>
                    </div>
                  @endif

                  <div class="col-12">
                    <p class="m-0"><span class="font-weight-bold">Итого:</span> {{ number_format($order->price + $order->ship_price - $order->sale, 0,',', ' ') }} ₸</p >
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="col-12 col-lg mt-20">
          <div class="card m-0 p-0 bg-dark-dm">
            <div class="row p-20">
              <form action="{{ route('admin.order.update', $order) }}" class="w-full" method="POST">
                @csrf
                @method('PUT')

                <div class="col-12">
                  <div class="form-group">
                    <label for="ship_status" class="required">Статус заказа</label>
                    <select class="form-control" name="ship_status" id="ship_status" required>
                      @foreach(\App\Models\Order::SHIP_STATUS_MAP as $status)
                        <option value="{{ $status }}" {{ old('ship_status', $order->ship_status) === $status ? 'selected' : null }}>{{ \App\Models\Order::$shipStatusMap[$status] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <label for="track" class="">Трек номер</label>
                    <input type="text" class="form-control" name="track" id="track" placeholder="Трек номер" value="{{ old('track', $order->ship_data->track ?? '') }}">
                  </div>
                </div>
                <button class="btn" type="submit">Сохранить</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-12">
          <hr class="bg-dark">
        </div>
        @foreach($order->items as $item)
          <div class="col-12 h-full col-md-6 col-lg-4 mt-10">
            <div class="card m-0 p-0 bg-dark-dm">
              <img src="{{ $item->product->thumbnail_jpg  }}" class="img-fluid rounded-top h-full w-full object-fit-cover" alt="...">
              <div class="content mx-20 mt-0">
                <div class="content-title my-20">
                  {{ $item->product->title }}
                </div>
                <div class="row">
                  <div class="col-6">
                    <span class="text-muted">Количество</span>
                    <p class="m-0">{{ $item->amount }} шт</p>
                  </div>
                  <div class="col-6">
                    <span class="text-muted">Размер</span>
                    <p class="m-0">{{ $item->skus->category->name }}: {{ $item->skus->title }}</p>
                  </div>
                  <div class="col-6 mt-10">
                    <span class="text-muted">Стоимость</span>
                    <p class="m-0">{{ number_format((int) $item->price, 0, ',', ' ') }}  ₸</p>
                  </div>
                  <div class="col-12 mt-10">
                    <hr class="bg-black">
                  </div>
                  <div class="col-12 mt-10 align-self-end d-flex">
                    <span class="m-0 p-0 text-muted d-flex align-self-center">Сумма: </span>
                    <span class="p-0 ml-10 font-weight-bolder d-block font-size-14">{{ number_format((int) $item->price * $item->amount, 0, ',', ' ') }}  ₸</span>

                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
@endsection

@section('script')

@endsection
