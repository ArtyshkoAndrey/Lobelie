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

          <button class="next-button">Следующая</button>
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
        <span text-index="2" class="subtitle">Новый завоз колец 2</span>
        <span text-index="3" class="subtitle">Новый завоз колец 3</span>
        <span text-index="4" class="subtitle">Новый завоз колец 4</span>
      </div>
    </div>

    <a href="#!" class="catalog-link">
      <i class="las la-shopping-cart"></i>
      <span>Перейти в каталог</span>
    </a>
  </div>

  <section id="new" class="my-5">
    <div class="container-fluid">
      <h1 class="section-title">Новые товары</h1>
      <div class="d-flex justify-content-center">
        <a href="#!" class="section-link">
          <span>Смотреть все</span>
          <i class="las la-long-arrow-alt-right"></i>
        </a>
      </div>
      <div class="row content">
        <div class="col-8 col-md-3">
          @include('user.layouts.item')
        </div>
        <div class="col-8 col-md-5 mx-auto">
          @include('user.layouts.item')
        </div>
        <div class="col-8 col-md-3">
          @include('user.layouts.item')
        </div>
      </div>
    </div>
  </section>

  <section id="catalog" class="my-5">
    <div class="container-fluid">
      <h1 class="section-title">Каталог</h1>
      <div class="row line-wrapper" v-for="i in 2">
        <div class="col-12 col-sm-6 d-flex flex-column" v-for="j in 2">
          <div class="category-wrapper">
{{--            <div class="d-flex flex-column w-100">--}}
              <picture>
                <source type="image/webp" srcset="{{ asset('images/category-image.png') }}">
                <source type="image/jpeg" srcset="{{ asset('images/category-image.png') }}">
                <img class="category-image" src="{{ asset('images/category-image.png') }}">
              </picture>
              <span class="category-name">Серьги</span>
              <div class="arrow-wrapper">
                <img src="{{ asset('images/arrow.svg') }}">
              </div>
              <a href="#!" class="category-link">Перейти в каталог</a>
            </div>
          </div>
{{--        </div>--}}
      </div>
    </div>
  </section>

  @include('user.layouts.instagram')
@endsection

