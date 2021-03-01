@extends('user.layouts.app')

@section('title', 'Каталог товаров')

@section('content')
  <div class="container-fluid" id="catalog">
    <div class="row">
      <div class="col-12 breadcrumb">

        {{--      @foreach($categories as $category)--}}
        {{--        <a class="breadcrumb-link" href="{{ route('product.all', ['category' => $category->id]) }}">{{ $category->name }}</a> /--}}
        {{--      @endforeach--}}
        {{--      {{ $product->title }}--}}
        <a class="breadcrumb-link" href="{{ route('index') }}">Lobelie intime</a>
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
            <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownSexLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="{{ count($filter['sex']) > 0 ? 'font-weight-bolder' : null }}">Пол</span>
            </a>
            <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
              @foreach(\App\Models\Product::SEX_MAP as $sex)
                <div class="checkbox">
                  <div class="row w-100 ml-0">
                    <div class="col pr-0 m-0">
                      <label class="form-check-label" for="sex-{{$sex}}">{{ \App\Models\Product::$sexMap[$sex] }} <span class="text-muted pl-1">{{ \App\Models\Product::whereSex($sex)->count() }}</span> </label>
                    </div>
                    <div class="col-auto pr-0">
                      <input type="checkbox" class="form-check-input" id="sex-{{$sex}}" name="sex[]" value="{{ $sex }}" {{ in_array($sex, $filter['sex']) ? 'checked' : null }}>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="col-md-auto col-12 d-none d-md-block filter">
            <div class="checkbox w-100 h-100 d-flex">
              <div class="row mr-3">
                <div class="col-auto pl-0 m-0">
                  <label class="form-check-label" for="sale"><span class="{{ $filter['sale'] ? 'font-weight-bolder' : null }}">Sale</span> <span class="text-muted pl-1">( {{ \App\Models\Product::whereOnSale('true')->count() }} )</span> </label>
                </div>
                <div class="col pr-0">
                  <input type="checkbox" class="form-check-input" id="sale" name="sale" value="1" {{ $filter['sale'] ? 'checked' : null }}>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-auto col-12 mt-2 mt-md-0 d-none d-md-block filter">
            <div class="checkbox w-100 h-100 d-flex">
              <div class="row">
                <div class="col-auto pl-0 m-0">
                  <label class="form-check-label" for="new"><span class="{{ $filter['new'] ? 'font-weight-bolder' : null }}">New</span> <span class="text-muted pl-1">( {{ \App\Models\Product::whereOnNew('true')->count() }} )</span> </label>
                </div>
                <div class="col pr-0 m-0">
                  <input type="checkbox" class="form-check-input" id="new" name="new" value="1" {{ $filter['new'] ? 'checked' : null }}>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-3 dropdown mb-3 mr-auto ml-0 px-0 mr-md-0 ml-md-auto filter">
          <div class="col-6 col-md-12 px-0 mr-auto">

            <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownSortLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="{{ count($filter['sex']) > 0 ? 'font-weight-bolder' : null }}">
                 @if($filter['order'] === 'sort-old')
                  <i class="fas fa-sort-amount-down"></i> Сначала старые
                @elseif($filter['order'] === 'sort-new')
                  <i class="fas fa-sort-amount-up"></i> Сначала новые
                @elseif($filter['order'] === 'sort-expensive')
                  <i class="fas fa-sort-amount-up"></i> Сначала дорогие
                @elseif($filter['order'] === 'sort-cheap')
                  <i class="fas fa-sort-amount-down"></i> Сначала дешёвые
                @endif
              </span>
            </a>
            <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownSortLink">
              <a href="#" role="button" onclick="orderSort('sort-old')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-old' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> Сначала старые</a>
              <a href="#" role="button" onclick="orderSort('sort-new')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-new' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> Сначала новые</a>
              <a href="#" role="button" onclick="orderSort('sort-expensive')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-expensive' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> Сначала дорогие</a>
              <a href="#" role="button" onclick="orderSort('sort-cheap')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-cheap' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> Сначала дешёвые</a>
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
      @foreach($items as $item)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
          @include('user.layouts.item', ['product' => $item])
        </div>
      @endforeach
    </div>

    <div class="row mt-4 justify-content-center">
      <div class="col-auto">
        {{ $items->onEachSide(1)->appends($filter)->links('vendor.pagination.bootstrap-4') }}
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

    function orderSort(type) {
      $('#order').val(type)
      $('#product-all').submit()
    }

    $('.form-check-input').on('click', function () {
      $('#product-all').submit()
    })




  </script>
@endsection
