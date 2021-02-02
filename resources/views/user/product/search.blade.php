@extends('user.layouts.app')

@section('title', count($products) > 0 ? 'DOCKU | Резултаты поиска' : 'DOCKU | Ничего не найдено')
@section('content')
{{--  Это один из вариантов, если будут товар то начнёт перебирать, если нет то будет вывводить всё что между empty и endforelse--}}
  <div class="container search-page pb-5">
    <div>
      <span class="title">Результат поиска</span>
      <span class="badge">{{ count($products) }}</span>
    </div>
    <div class="row">
      @forelse($products as $product)
      <div class="col-6 col-lg-4 col-xl-3 p-0">
        @include('user.layouts.item', ['item' => $product])
      </div>
      @empty
        <div class="not-found">
          <img src="{{ asset('images/search-notfound.svg') }}" alt="zero items">
          <span class="mt-2">
            Извените, мы не смогли найти<br>ничего по запросу
            <span class="query">{{ Request::get('q', '') }}</span>
          </span>
          <span class="another mt-2">Попробуйте найти что-то другое</span>
          <a href="{{ route('product.all') }}" class="btn btn-dark mt-2">Вернуться в каталог</a>
        </div>
      @endforelse
    </div>
  </div>
@endsection

