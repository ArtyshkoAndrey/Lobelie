@extends('admin.layouts.app')

@section('title', 'Новый промокод')

@section('css')

@endsection

@section('content')

  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('admin.coupon.index') }}">Промокоды</a>
            </li>
            <li class="breadcrumb-item active">Создание промокода</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Создание промокода</h3>
      </div>
      @if ($errors->any())
        <div class="col-12">
          <div class="card bg-dark-dm">
            <div class="invalid-feedback d-block">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endif
      <div class="col-12 p-0">
        <form action="{{ route('admin.coupon.store') }}" method="POST" class="w-full">
          @csrf
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="row row-eq-spacing-sm m-0 p-0">

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="code" class="required">Код</label>
                      <input type="text" class="form-control" name="code" id="code" placeholder="Код" value="{{ old('code') }}" required>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                    <label for="type" class="required">Тип скидки</label>
                    <select name="type" id="type" class="form-control">
                      @foreach(\App\Models\CouponCode::TYPE_MAP as $type)
                        <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : null }}>{{ \App\Models\CouponCode::$typeMap[$type] }}</option>
                      @endforeach
                    </select>
                  </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                    <label for="value" class="required">Стоимость (Проценты)</label>
                    <input type="number" class="form-control" name="value" id="value" placeholder="Стоимость" value="{{ old('value') }}" required>
                  </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="total" class="required">Кол-во</label>
                      <input type="number" class="form-control" name="total" id="total" placeholder="Кол-во" value="{{ old('total') }}" required>
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                    <label for="min_amount" class="required">Минимальная стоимость заказа</label>
                    <input type="number" class="form-control" name="min_amount" id="min_amount" placeholder="Стоимость" value="{{ old('min_amount') }}" required>
                  </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                    <label for="max_amount" class="required">Максимальная скидка</label>
                    <input type="number" class="form-control" name="max_amount" id="max_amount" placeholder="Стоимость" value="{{ old('max_amount') }}" required>
                  </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                    <label for="not_before" class="required">Дата начала</label>
                    <input type="date" name="not_before" class="form-control rounded-0" id="not_before" value="{{ old('not_before') }}" required>
                  </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="form-group">
                    <label for="not_after" class="required">Дата окончания</label>
                    <input type="date" name="not_after" class="form-control rounded-0" id="not_after" value="{{ old('not_after') }}" required>
                  </div>
                  </div>


                  <div class="col-12">
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="disabled_other_sales" value="0"><!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                      <input type="checkbox" name="disabled_other_sales" id="switch-1" value="1" {{ old('disabled_other_sales') ? 'checked' : null }}>
                      <label for="switch-1" class="text-danger">Не применять к товарам со скидкой</label>
                    </div>
                    <div class="custom-switch d-inline-block mr-10">
                      <input type="hidden" name="enabled" value="0">
                      <input type="checkbox" name="enabled" id="switch-2" value="1" {{ old('enabled') ? 'checked' : null }}>
                      <label for="switch-2">Включить промокод</label>
                    </div>
                  </div>

                  <div class="col-sm-6 mt-10">
                    <label for="products">Товары</label>
                    <select class="js-example-basic-multiple w-100 rounded-0" id="products" name="products[]" multiple="multiple">
                      @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-sm-6 mt-10">
                    <label for="brands">Цвета</label>
                    <select class="js-example-basic-multiple w-100 rounded-0" id="brands" name="brands[]" multiple="multiple">
                      @foreach(\App\Models\Brand::all() as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-sm-6 mt-10">
                    <label for="categories">Изделия</label>
                    <select class="js-example-basic-multiple w-100 rounded-0" id="categories" name="categories[]" multiple="multiple">
                      @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-sm-6"></div>

                  <div class="col-sm-6 mt-10">
                    <label for="disabled_products">Исключить товары</label>
                    <select class="js-example-basic-multiple w-100 rounded-0" id="disabled_products" name="disabled_products[]" multiple="multiple">
                      @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-sm-6 mt-10">
                    <label for="disabled_brands">Исключить цвета</label>
                    <select class="js-example-basic-multiple w-100 rounded-0" id="disabled_brands" name="disabled_brands[]" multiple="multiple">
                      @foreach(\App\Models\Brand::all() as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="col-sm-6 mt-10">
                    <label for="disabled_categories">Исключить изделия</label>
                    <select class="js-example-basic-multiple w-100 rounded-0" id="disabled_categories" name="disabled_categories[]" multiple="multiple">
                      @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                      @endforeach
                    </select>
                  </div>



                  <div class="col-12 d-flex justify-content-end">
                    <button class="btn btn-success" type="submit">Сохранить</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(() => {

      $('.js-example-basic-multiple').select2({
        width: '100%'
      })
    })
  </script>
@endsection
