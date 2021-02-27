@extends('admin.layouts.app')

@section('title', 'Список заказов')

@section('content')
    <div class="container-fluid mt-20 mb-20">
      <div class="row px-20 justify-content-center">
        <div class="col-12">
          <nav aria-label="Breadcrumb navigation example">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active"><a href="#">Заказы</a></li>
              <li class="breadcrumb-item"></li>
            </ul>
          </nav>
        </div>
        <div class="col-12">
          <h3>Заказы</h3>
        </div>

        <div class="col-12 col-md mb-20 pr-10">
          <form action="{{ route('admin.order.index') }}" method="get">
            <div class="input-group">
              <label for="email"></label>
              <input value="{{ $filter['user_email'] }}" type="email" name="user_email" id="email" placeholder="Заказы покупателя по email" class="form-control shadow-none border-none" required>
              <input type="hidden" name="user_name" value="{{ $filter['user_name'] }}">
              <input type="hidden" name="no" value="{{ $filter['no'] }}">
              <div class="input-group-append">
                <button class="btn rounded-right shadow-none border-none">
                  <i class="bx bx-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <div class="col-12 col-md mb-20 px-10">
          <form action="{{ route('admin.order.index') }}" method="get">
            <div class="input-group">
              <label for="no"></label>
              <input value="{{ $filter['no'] }}" type="text" name="no" id="no" placeholder="Номер заказа" class="form-control shadow-none border-none" required>
              <input type="hidden" name="user_email" value="{{ $filter['user_email'] }}">
              <input type="hidden" name="user_name" value="{{ $filter['user_name'] }}">
              <div class="input-group-append">
                <button class="btn rounded-right shadow-none border-none">
                  <i class="bx bx-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <div class="col-12 col-md mb-20 px-10">
          <form action="{{ route('admin.order.index') }}" method="get">
            <div class="input-group">
              <label for="user_name"></label>
              <input value="{{ $filter['user_name'] }}" type="text" name="user_name" id="user_name" placeholder="Имя покупателя" class="form-control shadow-none border-none" required>
              <input type="hidden" name="user_email" value="{{ $filter['user_email'] }}">
              <input type="hidden" name="no" value="{{ $filter['no'] }}">
              <div class="input-group-append">
                <button class="btn rounded-right shadow-none border-none">
                  <i class="bx bx-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <div class="col-md-auto col-12">
          <a href="{{ route('admin.order.index') }}" class="btn">Сбросить</a>
        </div>

        <div class="col-12">
          <div class="card m-0 p-10 bg-dark-dm">
            <a href="{{ route('admin.order.index', ['type' => null]) }}"
               class="mr-10 {{ $filter['type'] === null ? 'text-danger' : 'text-white' }}">
              Все заказы ({{ \App\Models\Order::count() }})
            </a>

            @foreach(\App\Models\Order::SHIP_STATUS_MAP as $status)
              <a href="{{ route('admin.order.index', ['type' => $status]) }}"
                 class="mr-10 {{ $filter['type'] === $status ? 'text-danger' : 'text-white' }}">
                {{ \App\Models\Order::$shipStatusMap[$status] }} ({{ \App\Models\Order::whereShipStatus($status)->count() }})
              </a>
            @endforeach

          </div>
        </div>

        <div class="col-12 mt-10">
          <div class="row">
            <div class="col-md">
              {{ $orders->links('vendor.pagination.halfmoon') }}
            </div>
          </div>
        </div>

        <div class="col-md-12 col-12 mt-10">
          <div class="card p-0 m-0 bg-dark-dm">
            <div class="table-responsive">
              <table class="table table-hover rounded" id="orders">
                <thead>
                  <tr>
                    <th>№</th>
                    <th>Стоимсть</th>
                    <th>Статус</th>
                    <th>Покупатель</th>
                  </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                  <tr class="{{ \App\Models\Order::getColorColumn($order->ship_status) }}" style="cursor: pointer" data-href='{{route('admin.order.edit', $order)}}'>
                    <th>
                      <p class="my-0">{{ $order->no }}</p>
                      <p class="font-size-9 my-0 font-weight-normal">{{ $order->created_at->format('d.m.Y') }} <span class="text-muted">{{ $order->created_at->format('H:i') }}</span></p>
                    </th>
                    <td>
                      <p class="my-0" data-toggle="tooltip" data-title="{{ 'Товары: ' .  number_format((int)$order->price, 0, ',', ' ') . '  ₸' }}
                        {{ 'Доставка: ' .  number_format((int)$order->ship_price, 0, ',', ' ') . '  ₸' }}">
                        {{ number_format((int)($order->price + $order->ship_price - $order->sale), 0, ',', ' ') }}  ₸
                      </p>
                      <p class="my-0 font-size-9 text-muted">{{ \App\Models\Order::$paymentMethodsMap[$order->payment_method] }}</p>
                    </td>
                    <td>{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
                    <td>{{ $order->user->name }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">Нет заказов</td>
                  </tr>
                @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
  <script>
    $("#orders tbody tr").click(function() {
      window.location = $(this).data("href");
    });
  </script>
@endsection
