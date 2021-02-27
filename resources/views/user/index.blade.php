@extends('user.layouts.app')
{{--@extends('user.layouts.app') Это без параметра и следовательно меню придёт dark автоматически --}}
{{-- Говорим шаблону что будет переменная в нём с значением --}}

@section('title', 'Главаня страница')

@section('content')
  <div class="home-slider">
    <div class="slides">
      <div class="slide-wrapper">

        @forelse($sliders as $slider)
          <img slide-index="{{ $loop->index + 1 }}" class="slide {{ $loop->first ? 'active' : null }}" src="{{ $slider->photo_storage }}" alt="{{ $slider->title }}">
        @empty
          <img slide-index="1" class="slide active" src="{{ asset('images/slide1.png') }}" alt="">
        @endforelse

        <div class="next-wrapper">
          @forelse($sliders as $slider)
            <img slide-index="{{ $loop->index +1 }}" class="next-slide {{ count($sliders) === 1 || $loop->index === 1 ? 'active' : null }}" src="{{ $slider->photo_storage }}" alt="{{ $slider->title }}">
          @empty
            <img slide-index="1" class="slide active" src="{{ asset('images/slide1.png') }}" alt="">
          @endforelse

          <button class="next-button">Следующая</button>
        </div>
      </div>

      <div class="dots">
        @forelse($sliders as $slider)
          <div slide-index="{{ $loop->index + 1}}" class="dot {{ $loop->first ? 'active' : null }}"></div>
        @empty
          <div slide-index="1" class="dot active"></div>
        @endforelse
      </div>
    </div>
    <div class="content">
      <div class="title-wrapper">
        <h1 class="title">Магазин<br>ювелирных изделий и купальников</h1>
      </div>
      <div class="subtitle-wrapper">

        @forelse($sliders as $slider)
          <span text-index="{{ $loop->index +1 }}" class="subtitle {{ $loop->first ? 'active' : null }}">{{ $slider->title }}</span>
        @empty
          <span text-index="1" class="subtitle active">Новый завоз колец 1</span>
        @endforelse
      </div>
    </div>

    <a href="{{ route('product.all') }}" class="catalog-link">
      <i class="las la-shopping-cart"></i>
      <span>Перейти в каталог</span>
    </a>
  </div>

  <section id="new" class="my-5">
    <div class="container-fluid">
      <h1 class="section-title">Новые товары</h1>
      <div class="d-flex justify-content-center">
        <a href="{{ route('product.all', ['sale' => true]) }}" class="section-link">
          <span>Смотреть все</span>
          <i class="las la-long-arrow-alt-right"></i>
        </a>
      </div>
      <div class="row content">
        @foreach($newProducts as $product)
          @if($loop->first || $loop->last)
            <div class="col-8 col-md-3">
              @include('user.layouts.item', ['product' => $product])
            </div>

          @else
            <div class="col-8 col-md-4 mx-auto">
              @include('user.layouts.item', ['product' => $product])
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </section>


  <section id="catalog-section" class="my-5">
    <div class="container-fluid">
      <h1 class="section-title">Каталог</h1>

      @if (count($categories) > 0)
        <div class="row line-wrapper">
          @if (isset($categories[0]))
            <div class="col-12 col-md-4 col-sm-6 offset-md-1 d-flex flex-column" >
              <div class="category-wrapper">
                <img class="category-image" src="{{ $categories[0]->photo_storage }}" alt="{{ $categories[0]->name }}">
                <span class="category-name">{{ $categories[0]->name }}</span>
                <div class="arrow-wrapper">
                  <img src="{{ asset('images/arrow.svg') }}" alt="">
                </div>
                <a href="{{ route('product.all', ['category' => $categories[0]->id]) }}" class="category-link">Перейти в каталог</a>
              </div>
            </div>
          @endif

          @if (isset($categories[1]))
            <div class="col-12 col-md-4 col-sm-6 offset-md-1 d-flex flex-column" >
              <div class="category-wrapper">
                <img class="category-image" src="{{ $categories[1]->photo_storage }}" alt="{{ $categories[1]->name }}">
                <span class="category-name">{{ $categories[1]->name }}</span>
                <div class="arrow-wrapper">
                  <img src="{{ asset('images/arrow.svg') }}" alt="">
                </div>
                <a href="{{ route('product.all', ['category' => $categories[1]->id]) }}" class="category-link">Перейти в каталог</a>
              </div>
            </div>
          @endif
        </div>

        <div class="row line-wrapper">

          @if (isset($categories[2]))
            <div class="col-12 col-md-4 col-sm-6 offset-md-1 d-flex flex-column" >
              <div class="category-wrapper">
                <img class="category-image" src="{{ $categories[2]->photo_storage }}" alt="{{ $categories[1]->name }}">
                <span class="category-name">{{ $categories[2]->name }}</span>
                <div class="arrow-wrapper">
                  <img src="{{ asset('images/arrow.svg') }}" alt="">
                </div>
                <a href="{{ route('product.all', ['category' => $categories[2]->id]) }}" class="category-link">Перейти в каталог</a>
              </div>
            </div>
          @endif

          @if (isset($categories[3]))
            <div class="col-12 col-md-4 col-sm-6 offset-md-1 d-flex flex-column" >
              <div class="category-wrapper">
                <img class="category-image" src="{{ $categories[3]->photo_storage }}" alt="{{ $categories[1]->name }}">
                <span class="category-name">{{ $categories[3]->name }}</span>
                <div class="arrow-wrapper">
                  <img src="{{ asset('images/arrow.svg') }}" alt="">
                </div>
                <a href="{{ route('product.all', ['category' => $categories[3]->id]) }}" class="category-link">Перейти в каталог</a>
              </div>
            </div>
          @endif

        </div>
      @endif

    </div>
  </section>

  @include('user.layouts.instagram')
@endsection

