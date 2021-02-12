@extends('user.layouts.app')

@section('title', 'DOCKU | Каталог товаров')

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
        <span class="breadcrumb-current">Каталог</span>
      </div>
      <div class="col-12">
        <h1 class="title">Каталог товаров</h1>
      </div>
    </div>
    <form action="{{ route('product.all') }}" class="" method="get" id="product-all">
      <input type="hidden" name="order" id="order" value="{{ $filter['order'] }}">
      <div class="row m-0 w-100 align-items-center flex-column-reverse flex-md-row">
        <div class="col-12 col-md-9 d-flex flex-column flex-md-row px-0">
          <div class="col-12 col-md-2 dropdown d-none d-md-block filter mb-3 px-0 pr-md-3">
            <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownCategoryLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="{{ count($filter['category']) > 0 ? 'font-weight-bolder' : null }}">Изделия</span>
            </a>
            <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownCategoryLink">
              @foreach(\App\Models\Category::all() as $category)
                <div class="checkbox">
                  <div class="row w-100 ml-0">
                    <div class="col pl-0 m-0">
                      <label class="form-check-label" for="category-{{$category->id}}">{{ $category->name }} <span class="text-muted pl-1">{{ $category->products()->count() }}</span> </label>
                    </div>
                    <div class="col-auto pr-0">
                      <input type="checkbox" class="form-check-input" id="category-{{$category->id}}" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, $filter['category']) ? 'checked' : null }}>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-12 col-md-2 dropdown d-none d-md-block filter mb-3 px-0 px-md-3">
            <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="{{ count($filter['brand']) > 0 ? 'font-weight-bolder' : null }}">Цвет</span>
            </a>
            <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
              @foreach($brands = \App\Models\Brand::all() as $brand)
                <div class="checkbox">
                  <div class="row w-100 ml-0">
                    <div class="col pl-0 m-0">
                      <label class="form-check-label" for="brand-{{$brand->id}}">{{ $brand->name }} <span class="text-muted pl-1">{{ $brand->products()->count() }}</span> </label>
                    </div>
                    <div class="col-auto pr-0">
                      <input type="checkbox" class="form-check-input" id="brand-{{$brand->id}}" name="brand[]" value="{{ $brand->id }}" {{ in_array($brand->id, $filter['brand']) ? 'checked' : null }}>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-12 col-md-2 dropdown d-none d-md-block filter mb-3 px-0 px-md-3">
            <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="{{ count($filter['brand']) > 0 ? 'font-weight-bolder' : null }}">Пол</span>
            </a>
            <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
              @foreach($brands = \App\Models\Brand::all() as $brand)
                <div class="checkbox">
                  <div class="row w-100 ml-0">
                    <div class="col pr-0 m-0">
                      <label class="form-check-label" for="brand-{{$brand->id}}">{{ $brand->name }} <span class="text-muted pl-1">{{ $brand->products()->count() }}</span> </label>
                    </div>
                    <div class="col-auto pr-0">
                      <input type="checkbox" class="form-check-input" id="brand-{{$brand->id}}" name="brand[]" value="{{ $brand->id }}" {{ in_array($brand->id, $filter['brand']) ? 'checked' : null }}>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="col-12 col-md-3 dropdown mb-3 mr-auto ml-0 px-0 mr-md-0 ml-md-auto filter">
          <div class="col-6 col-md-12 px-0 mr-auto">

            <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="{{ count($filter['sex']) > 0 ? 'font-weight-bolder' : null }}">С начала новые</span>
            </a>
            <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
              @foreach(\App\Models\Product::SEX_MAP as $sex)
                <div class="checkbox">
                  <div class="row w-100 ml-0">
                    <div class="col pl-0 m-0">
                      <label class="form-check-label" for=sex-{{$sex}}">{{ \App\Models\Product::$sexMap[$sex] }} <span class="text-muted pl-1">{{ \App\Models\Product::whereSex($sex)->count() }}</span> </label>
                    </div>
                    <div class="col-auto pr-0">
                      <input type="checkbox" class="form-check-input" id="sex-{{$sex}}" name="sex[]" value="{{ $sex }}" {{ in_array($sex, $filter['sex']) ? 'checked' : null }}>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-auto px-0">
            <a class="open-filters active ml-auto pr-0" onclick="toggleFilters()">
              <span class="las la-filter" style="font-size: 1.9em;"></span>
              <span class="badge rounded-pill badge-notification bg-dark text-white">{{ $counter }}</span>
            </a>
            <a class="close-filters" onclick="toggleFilters()" >
              <i class="las la-times"></i>
            </a>
          </div>
        </div>
      </div>
    </form>
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
      let filterCloseButton = $('.close-filters')
      let filterOpenButton = $('.open-filters')

      $("#catalog .dropdown-menu").on('click', function (event) {
        event.stopPropagation();
      });

      window.toggleFilters = function() {
        for (let filter of $('.filter')) {
          $(filter).toggleClass('d-flex')
        }
        filterCloseButton.toggleClass('active')
        filterOpenButton.toggleClass('active')
      }
    }

    // function uncheckProps(el) {
    //   el.prop('checked', false)
    //   $('#product-all').submit()
    // }

    // function orderSort(type) {
    //   $('#order').val(type)
    //   $('#product-all').submit()
    // }




  </script>
@endsection
