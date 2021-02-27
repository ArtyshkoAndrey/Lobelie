@extends('admin.layouts.app')

@section('title', 'Список городов для самовывоза')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">Города для самовывоза</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Города для самовывоза</h3>
          </div>

          <div class="col-auto px-10">
            <a href="#modal-city-add" class="btn d-block">Добавить город</a>
          </div>

        </div>
      </div>

      <div class="col-md-4 col-8">
        <form action="{{ route('admin.settings.pickup.index') }}" method="get">
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
        <a href="{{ route('admin.settings.pickup.index') }}" class="btn">Сбросить</a>
      </div>

      <div class="col-12 mt-10">
        <div class="row">
          <div class="col-md">
            {{ $cities->links('vendor.pagination.halfmoon') }}
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($cities as $city)
            <div class="col-12 col-md-6 mt-10 px-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center justify-content-between">
                  <div class="col-4 col-md-4 col-lg-auto">
                    <h5 class="p-0 m-0 d-block">{{ $city->name }}</h5>
                  </div>

                  <div class="col-md-auto col">
                    <div class="row justify-content-center">
                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.settings.pickup.destroy', $city->id) }}" method="POST">
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
  <div class="modal ie-scroll-fix position-absolute" id="modal-city-add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-dark-light-dm bg-light-lm ">
{{--        <a href="#" class="close" style="" role="button" aria-label="Close">--}}
{{--          <span aria-hidden="true">&times;</span>--}}
{{--        </a>--}}
        <div class="container">

          <div class="row justify-content-center">
            <div class="col-12">
              <h1 class="modal-title font-size-16 text-center">Добавления города в список</h1>
            </div>
            <div class="col-md-8 col-12">
              <form action="{{ route('admin.settings.pickup.store') }}" method="POST">
                @csrf
                <city :name="'city'" :id="'city'" ></city>

                <input class="btn btn-primary btn-block" type="submit" value="Добавить">
                <a href="#" class="btn btn-danger d-block mt-10" role="button" aria-label="Close">Отмена</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')


@endsection

@section('script')
  <script>

  </script>
@endsection
