@extends('admin.layouts.app')

@section('title', 'Список размеров')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing justify-content-center">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">Размеры</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Размеры</h3>
          </div>

          <div class="col-md-auto col-12 mt-10 mt-md-0 px-10">
            <a href="#modal-skus-category-add" class="btn d-block">Создать новую категорию</a>
          </div>

        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($skus_categories as $sk)
            <div class="col-12 mt-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-4 col-md-4 col-lg-auto">
                    <a href="#modal-skus-{{ $sk->id }}" class="text-decoration-none text-danger m-0 p-0"><h5 class="p-0 m-0 d-block">{{ $sk->name }}</h5></a>
                  </div>

                  <div class="col-auto h-full col-md-auto ml-auto ml-md-10">
                    <p class="m-0">Кол-во размеров: {{ count($sk->skuses) }}</p>
                  </div>

                  <div class="col-md col-12">
                    <div class="row justify-content-center">
                      <div class="col-md-10 col-lg-auto col-4 pl-md-10 pl-lg-0 ml-lg-auto mt-10 mt-md-0">
                        <a href="#modal-skus-add" data-id-sk="{{ $sk->id }}" id="skus-add-btn-{{ $sk->id }}" class="btn bg-transparent text-primary shadow-none border-0 d-block skus-add"><i class="bx bx-plus font-size-16"></i></a>
                      </div>

                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <a href="{{ route('admin.skus.edit', $sk->id) }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                      </div>
                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.skus-category.destroy', $sk->id) }}" method="POST">
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
  @foreach($skus_categories as $sk)
    <!-- Full-screen modal -->
    <div class="modal modal-full ie-scroll-fix" id="modal-skus-{{ $sk->id }}" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark-light-dm bg-light-lm ">
          <a href="#" class="close" role="button" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <div class="container">

            <div class="row justify-content-center">
              <div class="col-12">
                <div class="row justify-content-center">
                  <div class="col-auto">
                    <h1 class="modal-title font-size-24 text-center">{{ $sk->name }}</h1>
                  </div>
                  <div class="col-auto ml-10">
                    <a href="#modal-skus-add" data-id-sk="{{ $sk->id }}" id="skus-add-btn-{{ $sk->id }}" class="btn shadow-none border-0 skus-add">Добавить размер</a>

                  </div>
                </div>
              </div>
              <div class="col-md-8 col-12">
                <div class="row">

                  @foreach($sk->skuses()->orderBy('weight')->get() as $skus)
                    <div class="col-12 mt-10">
                      <div class="card p-20 bg-dark-dm m-0">
                        <div class="row">
                          <div class="col-4 col-md-auto mr-md-auto align-self-center">
                            <h5 class="p-0 m-0 d-block">{{ $skus->title }}</h5>
                          </div>

                          <div class="col-auto col-md-auto ml-auto ml-md-0 align-self-center">
                            <p class="m-0">Кол-во товаров: {{ $skus->products()->count() }}</p>
                          </div>

                          <div class="col-auto col-md-auto align-self-center ml-10 mx-md-auto">
                            <p class="m-0">Вес: {{ $skus->weight }}</p>
                          </div>
                          <div class="col-md-auto col-6 ml-md-auto mt-10 mt-md-0 pr-10 pr-md-0">
                            <a href="{{ route('admin.skus.edit', $skus) }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                          </div>
                          <div class="col-md-auto col-6 mx-md-10  mt-10 mt-md-0 pl-10 pl-md-0">
                            <form action="{{ route('admin.skus.destroy', $skus) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn shadow-none bg-transparent text-danger border-0 d-block"><i class="bx bx-trash font-size-16"></i></button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <div class="modal ie-scroll-fix" id="modal-skus-add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-dark-light-dm bg-light-lm ">
        <a href="#" class="close" role="button" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <div class="container">

          <div class="row justify-content-center">
            <div class="col-12">
              <h1 class="modal-title font-size-16 text-center">Добавление нового размера</h1>
            </div>
            <div class="col-md-8 col-12">
              <form action="{{ route('admin.skus.store') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="title" class="required">Наименование</label>
                  <input type="text" name="title" id="title" class="form-control" placeholder="Наименование" required="required">
                </div>
                <div class="form-group">
                  <label for="weight" class="required">Вес</label>
                  <input type="number" id="weight" name="weight" class="form-control" placeholder="Вес" required="required">
                </div>

                <div class="form-group">
                  <label for=sk class="required">Категория</label>
                  <select id="sk" name="sk" class="form-control" required="required">
                    @foreach($skus_categories as $sk)
                      <option value="{{ $sk->id }}">{{ $sk->name }}</option>
                    @endforeach

                  </select>
                </div>

                <input class="btn btn-primary btn-block" type="submit" value="Создать">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal ie-scroll-fix" id="modal-skus-category-add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-dark-light-dm bg-light-lm ">
        <a href="#" class="close" role="button" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <div class="container">

          <div class="row justify-content-center">
            <div class="col-12">
              <h1 class="modal-title font-size-16 text-center">Добавление новой категории зармеров</h1>
            </div>
            <div class="col-md-8 col-12">
              <form action="{{ route('admin.skus-category.store') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="name" class="required">Наименование</label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Наименование" required="required">
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
