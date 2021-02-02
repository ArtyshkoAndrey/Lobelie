@extends('user.layouts.app')

@section('title', 'DOCKU | Каталог товаров')

@section('content')
  <div class="container" id="catalog">
    <div class="mb-2">
      <span class="title">Каталог товаров</span>
      <span class="badge">{{ $itemsCount }}</span>
      <button class="ml-auto d-flex d-md-none position-relative" style="border: none; background: transparent; color: #2D3134;" onclick="toggleFilters()">
        <span class="bx bx-filter-alt" style="font-size: 1.4em;"></span>
        <span class="badge rounded-pill badge-notification bg-dark text-white">{{ $counter }}</span>
      </button>
    </div>

    <form action="{{ route('product.all') }}" class="" method="get" id="product-all">
      <input type="hidden" name="order" id="order" value="{{ $filter['order'] }}">
      <div class="row m-0 w-100 align-items-center">
        <div class="col-12 col-md-auto dropdown">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownCategoryLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['category']) > 0 ? 'font-weight-bolder' : null }}">Категории</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownCategoryLink">
            @foreach(\App\Models\Category::all() as $category)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="category-{{$category->id}}" name="category[]" value="{{ $category->id }}" {{ in_array($category->id, $filter['category']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="category-{{$category->id}}">{{ $category->name }} <span class="text-muted pl-1">{{ $category->products()->count() }}</span> </label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-12 col-md-auto dropdown d-none d-md-block hiddable-filter">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['brand']) > 0 ? 'font-weight-bolder' : null }}">Бренды</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
            @foreach($brands = \App\Models\Brand::all() as $brand)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="brand-{{$brand->id}}" name="brand[]" value="{{ $brand->id }}" {{ in_array($brand->id, $filter['brand']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="brand-{{$brand->id}}">{{ $brand->name }} <span class="text-muted pl-1">{{ $brand->products()->count() }}</span> </label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-12 col-md-auto dropdown">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['size']) > 0 ? 'font-weight-bolder' : null }}">Размеры</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
            @foreach($attributes as $attr)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="attr-{{$attr->id}}" name="size[]" value="{{ $attr->id }}" {{ in_array($attr->id, $filter['size']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for="attr-{{$attr->id}}">{{ $attr->title }} <span class="text-muted pl-1">{{ $attr->category->name }}</span></label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-12 col-md-auto dropdown d-none d-md-block hiddable-filter">
          <a href="#" class="text-dark dropdown-toggle border-hover text-decoration-none" role="button" id="dropdownBrandLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="{{ count($filter['sex']) > 0 ? 'font-weight-bolder' : null }}">Пол</span>
          </a>
          <div class="dropdown-menu dropdown-shadow rounded-0 border-0 py-3 px-4 overflow-auto" aria-labelledby="dropdownBrandLink">
            @foreach(\App\Models\Product::SEX_MAP as $sex)
              <div class="checkbox">
                <div class="row">
                  <div class="col-auto pr-0">
                    <input type="checkbox" class="form-check-input" id="sex-{{$sex}}" name="sex[]" value="{{ $sex }}" {{ in_array($sex, $filter['sex']) ? 'checked' : null }}>
                  </div>
                  <div class="col m-0">
                    <label class="form-check-label" for=sex-{{$sex}}">{{ \App\Models\Product::$sexMap[$sex] }} <span class="text-muted pl-1">{{ \App\Models\Product::whereSex($sex)->count() }}</span> </label>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-auto d-none d-md-block hiddable-filter">
          <div class="checkbox w-100 h-100 d-flex align-items-center">
            <div class="row">
              <div class="col-auto pr-0">
                <input type="checkbox" class="form-check-input" id="sale" name="sale" value="true" {{ $filter['sale'] ? 'checked' : null }}>
              </div>
              <div class="col m-0">
                <label class="form-check-label" for="sale">Sale</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-auto d-none d-md-block hiddable-filter">
          <div class="checkbox w-100 h-100 d-flex align-items-center">
            <div class="row">
              <div class="col-auto pr-0">
                <input type="checkbox" class="form-check-input" id="new" name="new" value="true" {{ $filter['new'] ? 'checked' : null }}>
              </div>
              <div class="col m-0">
                <label class="form-check-label" for="new">New</label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-auto mt-3 mt-md-0">
          <button class="btn btn-primary w-100">Применить</button>
        </div>

        <div class="col-12 col-md-auto dropdown ml-auto mt-2 mt-md-0">
          <a href="#" class="text-dark dropdown-toggle text-decoration-none" role="button" id="dropdownOrderLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if($filter['order'] === 'sort-old')
              <i class="fas fa-sort-amount-down"></i> С начало старые
            @elseif($filter['order'] === 'sort-new')
              <i class="fas fa-sort-amount-up"></i> С начало новые
            @elseif($filter['order'] === 'sort-expensive')
              <i class="fas fa-sort-amount-up"></i> С начало дорогие
            @elseif($filter['order'] === 'sort-cheap')
              <i class="fas fa-sort-amount-down"></i> С начало дешёвые
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-shadow rounded-0 border-0 py-3 px-4" aria-labelledby="dropdownOrderLink">
            <a href="#" role="button" onclick="orderSort('sort-old')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-old' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> С начало старые</a>
            <a href="#" role="button" onclick="orderSort('sort-new')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-new' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> С начало новые</a>
            <a href="#" role="button" onclick="orderSort('sort-expensive')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-expensive' ? 'active' : '' }}"><i class="fas fa-sort-amount-up"></i> С начало дорогие</a>
            <a href="#" role="button" onclick="orderSort('sort-cheap')" class="dropdown-item bg-transparent {{ $filter['order'] === 'sort-cheap' ? 'active' : '' }}"><i class="fas fa-sort-amount-down"></i> С начало дешёвые</a>
          </div>
        </div>
      </div>
    </form>
    <hr>
    <div class="row ml-1">
      @foreach($filter['category'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Category::find($value)->name }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#category-{{$value}}'))"><i class="bx bx-x"></i></button>
        </div>
      @endforeach

      @foreach($filter['brand'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Brand::find($value)->name }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#brand-{{$value}}'))"><i class="bx bx-x"></i></button>
        </div>
      @endforeach
      @foreach($filter['size'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Skus::find($value)->title }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#attr-{{$value}}'))"><i class="bx bx-x"></i></button>
        </div>
      @endforeach

      @foreach($filter['sex'] as $value)
        <div class="col-auto px-2 py-1 m-1 filter-badge">
          <span class="font-weight-light">{{ \App\Models\Product::$sexMap[$sex] }}</span>
          <button class="btn bg-transparent h5 shadow-0 border-none p-0" onclick="uncheckProps($('#sex-{{$value}}'))"><i class="bx bx-x"></i></button>
        </div>
      @endforeach

      <div class="col-auto px-2 py-1 m-1 clear-filters">
        <a href="{{ route('product.all') }}">Очистить всё</a>
      </div>
    </div>
  <hr>
  </div>


  <div class="container">
    <div class="row">
      @foreach($items as $item)
        <div class="col-6 col-lg-4 col-xl-3 p-0">
          @include('user.layouts.item', array('item' => $item))
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
      $("#catalog .dropdown-menu").on('click', function (event) {
        event.stopPropagation();
      });
    }

    function uncheckProps(el) {
      el.prop('checked', false)
      $('#product-all').submit()
    }

    function orderSort(type) {
      $('#order').val(type)
      $('#product-all').submit()
    }

    function toggleFilters() {
      for (let filter of $('.hiddable-filter')) {
        $(filter).toggleClass('d-block')
      }
    }
  </script>
@endsection
