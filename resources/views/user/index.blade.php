@extends('user.layouts.app', ['theme_menu' => 'light-menu'])
{{--@extends('user.layouts.app') Это без параметра и следовательно меню придёт dark автоматически --}}
{{-- Говорим шаблону что будет переменная в нём с значением --}}

@section('title', 'DOCKU | Главаня страница')

@section('content')
  <div class="home-slider">
    <div class="slides">
      <div class="slide-wrapper">
        <img slide-index="1" class="slide active" src="{{ asset('images/slide1.png') }}">
        <img slide-index="2" class="slide" src="{{ asset('images/slide2.png') }}">
        <img slide-index="3" class="slide" src="{{ asset('images/slide1.png') }}">
        <img slide-index="4" class="slide" src="{{ asset('images/slide2.png') }}">

        <div class="next-wrapper">
          <img slide-index="1" class="next-slide" src="{{ asset('images/slide1.png') }}">
          <img slide-index="2" class="next-slide active" src="{{ asset('images/slide2.png') }}">
          <img slide-index="3" class="next-slide" src="{{ asset('images/slide1.png') }}">
          <img slide-index="4" class="next-slide" src="{{ asset('images/slide2.png') }}">
          
        </div>
      </div>

      <div class="dots">
        <div slide-index="1" class="dot active"></div>
        <div slide-index="2" class="dot"></div>
        <div slide-index="3" class="dot"></div>
        <div slide-index="4" class="dot"></div>
      </div>
    </div>
    <div class="content">
      <div class="title-wrapper">
        <h1 class="title">Магазин<br>ювелирных изделий и купальников</h1>
      </div>
      <div class="subtitle-wrapper">
        <span text-index="1" class="subtitle active">Новый завоз колец 1</span>
        <span text-index="1" class="subtitle">Новый завоз колец 2</span>
        <span text-index="1" class="subtitle">Новый завоз колец 3</span>
        <span text-index="1" class="subtitle">Новый завоз колец 4</span>
      </div>
    </div>
  </div>



  <section>
{{--    TODO: Доделать сортировку товаров в каталоге и вывести ссылку--}}
    @include('user.layouts.category-preview', ['title' => 'Новое поступление', 'link' => route('product.all'), 'products' => $newProducts])

    {{--    TODO: Доделать сортировку товаров в каталоге и вывести ссылку--}}
    @include('user.layouts.category-preview', ['title' => 'Хит продаж', 'link' => route('product.all'), 'products' => $hitProducts])

    @foreach($categories as $category)
      @if($category->products->count() > 0)
        @include('user.layouts.category-preview', ['title' => $category->name, 'link' => route('product.all', ['category' => $category->id]), 'products' => $category->products()->orderByDesc('id')->take(4)->get()])
      @endif
    @endforeach

  </section>

  @include('user.layouts.instagram')
@endsection

