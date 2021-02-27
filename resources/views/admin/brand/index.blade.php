@extends('admin.layouts.app')

@section('title', 'Список цветов')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">Цвета</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Цвета</h3>
          </div>

          <div class="col-auto px-10">
            <a href="#modal-brand-add" class="btn d-block">Создать новый цвет</a>
          </div>

        </div>
      </div>

      <div class="col-md-4 col-8">
        <form action="{{ route('admin.brand.index') }}" method="get">
          <div class="input-group">
            <label for="name"></label>
            <input value="{{ $filter['name'] }}" type="text" name="name" id="name" placeholder="Наименование" class="form-control shadow-none border-none" required>
            <div class="input-group-append">
              <button type="submit" class="btn rounded-right shadow-none border-none">
                <i class="bx bx-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-auto col">
        <a href="{{ route('admin.brand.index') }}" class="btn">Сбросить</a>
      </div>

      <div class="col-12 mt-10">
        <div class="row">
          <div class="col-md">
            {{ $brands->links('vendor.pagination.halfmoon') }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($brands as $brand)
            <div class="col-12 mt-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-4 col-md-4 col-lg-auto">
                    <a href="#modal-brand-{{ $brand->id }}" class="text-decoration-none text-danger m-0 p-0"><h5 class="p-0 m-0 d-block">{{ $brand->name }}</h5></a>
                  </div>

                  <div class="col-auto h-full col-md-auto ml-auto ml-md-10 d-none d-md-block">
                    <p class="m-0">Кол-во товаров: {{ count($brand->products) }}</p>
                  </div>

                  <div class="col-md col">
                    <div class="row justify-content-center">

                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10 ml-lg-auto">
                        <a href="#modal-brand-{{ $brand->id }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                      </div>
                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button class="btn shadow-none bg-transparent text-danger border-0 w-full d-block"><i class="bx bx-trash font-size-16"></i></button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
@endsection

@section('modal')
  @foreach($brands as $brand)
    <!-- Full-screen modal -->
    <div class="modal ie-scroll-fix" id="modal-brand-{{ $brand->id }}" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark-light-dm bg-light-lm ">
          <a href="#" class="close" role="button" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <div class="container">

            <div class="row justify-content-center">
              <div class="col-md-8 col-12">
                <form action="{{ route('admin.brand.update', $brand) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="name" class="required">Наименование</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Наименование" required="required" value="{{ $brand->name }}">
                  </div>

                  <input class="btn btn-primary btn-block" type="submit" value="Изменить">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <div class="modal ie-scroll-fix" id="modal-brand-add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-dark-light-dm bg-light-lm ">
        <a href="#" class="close" role="button" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <div class="container">

          <div class="row justify-content-center">
            <div class="col-12">
              <h1 class="modal-title font-size-16 text-center">Добавление нового цвета</h1>
            </div>
            <div class="col-md-8 col-12">
              <form action="{{ route('admin.brand.store') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="name" class="required">Наименование</label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Наименование" required="required" value="{{ old('name') }}">
                </div>

                <input class="btn btn-primary btn-block" type="submit" value="Создать">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Setting the initial number of clicks
      let inputIdSkElem = document.getElementById('sk');

      // Handle click events (overridden)
      halfmoon.clickHandler = function(event) {
        let target = event.target;
        if (target.matches(".skus-add")) {
          console.log(target.getAttribute("data-id-sk"))
          inputIdSkElem.value = target.getAttribute("data-id-sk")
        }
        // You can handle other click events here using if or else-if statements
      }
    });
  </script>
@endsection
