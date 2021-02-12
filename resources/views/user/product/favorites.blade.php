@extends('user.layouts.app')

@section('title', 'DOCKU | Избранные товары')

@section('content')
  <div class="container-fluid" id="catalog">
    <div class="row">
      <div class="col-12 breadcrumb">

        {{--      @foreach($categories as $category)--}}
        {{--        <a class="breadcrumb-link" href="{{ route('product.all', ['category' => $category->id]) }}">{{ $category->name }}</a> /--}}
        {{--      @endforeach--}}
        {{--      {{ $product->title }}--}}
        <a class="breadcrumb-link" href="#!">Lobelie intime</a>
        <span class="breadcrumb-divider"> / </span>
        <span class="breadcrumb-current">Избранное</span>
      </div>
      <div class="col-12">
        <h1 class="title">Избранные товары</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-6 col-md-4 col-lg-3 mb-4" v-for="i in 12">
        @include('user.layouts.item')
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    window.onload = function() {
      $("#catalog .dropdown-menu").on('click', function (event) {
        event.stopPropagation();
      });
    }
  </script>
@endsection
