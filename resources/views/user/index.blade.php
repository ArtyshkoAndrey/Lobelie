@extends('user.layouts.app', ['theme_menu' => 'light-menu'])
{{--@extends('user.layouts.app') Это без параметра и следовательно меню придёт dark автоматически --}}
{{-- Говорим шаблону что будет переменная в нём с значением --}}

@section('title', 'DOCKU | Главаня страница')

@section('content')
  <section id="intro" class="container-fluid m-0 d-flex align-items-center">
    <div class="row">
      <div class="col-md-6">
        <h1 class="title">Магазин cноубордов</h1>
        <span class="subtitle">С одним из лучших<br>ассортиментов в Алматы</span>
        <a href="{{ route('product.all') }}" class="preview">Начать покупки <i class="bx bx-sm bx-run"></i></a>
      </div>
    </div>
  </section>

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

