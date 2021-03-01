@extends('user.layouts.app')

@section('title', count($products) > 0 ? 'Резултаты поиска' : 'Ничего не найдено')
@section('content')
{{--  Это один из вариантов, если будут товар то начнёт перебирать, если нет то будет вывводить всё что между empty и endforelse--}}
  <div class="container-fluid search-page pb-5">
    <div>
      <span class="title">Результат поиска</span>
      <span class="badge rounded-0">{{ count($products) }}</span>
    </div>
    <div class="row">
      @forelse($products as $product)
      <div class="col-6 col-lg-4 col-xl-3">
        @include('user.layouts.item', ['item' => $product])
      </div>
      @empty
        <div class="not-found">
          <span class="mt-2">
            Извените, мы не смогли найти<br>ничего по запросу
            <span class="query">{{ Request::get('q', '') }}</span>
          </span>
          <span class="another mt-2">Попробуйте найти что-то другое</span>
          <a href="{{ route('product.all') }}" class="btn btn-dark mt-2 rounded-0">Вернуться в каталог</a>
        </div>
      @endforelse
    </div>
  </div>
@endsection

