@extends('admin.layouts.app')

@section('title', 'Список слайдера')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="{{ route('admin.slider.index') }}">Список Slider</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Slider</h3>
          </div>


          <div class="col-auto px-10">
            <a href="#modal-slider-add" class="btn d-block">Создать новую карточку в slider</a>
          </div>

        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($sliders as $slider)
            <div class="col-12 mt-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-md-1 pr-10">
                    <img src="{{ $slider->photo_storage }}" class="img-fluid rounded" alt="{{ $slider->title }}">
                  </div>
                  <div class="col-4 col-md-4 col-lg-auto">
                    <h5 class="text-decoration-none text-danger m-0 p-0">{{ $slider->title }}</h5>
                  </div>

                  <div class="col-md col">
                    <div class="row justify-content-center">

                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10 ml-lg-auto">
                        <a href="#modal-slider-{{ $slider->id }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                      </div>
                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST">
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

  @foreach($sliders as $slider)
    <div class="modal ie-scroll-fix" id="modal-slider-{{$slider->id}}" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark-light-dm bg-light-lm ">
          <a href="#" class="close" role="button" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <div class="container">

            <div class="row justify-content-center">
              <div class="col-12">
                <h1 class="modal-title font-size-16 text-center">Обновление карточки slider</h1>
              </div>
              <div class="col-md-8 col-12">
                <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="title" class="required">Заголовок</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Заголовок" required="required" value="{{ old('title', $slider->title) }}">
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-6 mr-10">
                        <div class="custom-file mb-20">
                          <label class="required bg-transparent disabled p-0 shadow-none border-0">Фотография</label>
                          <input type="file"
                                 id="photo-{{ $slider->id }}"
                                 class="w-full"
                                 name="photo"
                                 value="{{ $slider->photo }}"
                                 accept=".jpg,.png">

                          <div class="wrapper-hover-image" onclick="$('#photo-{{ $slider->id }}').click()">
                            <img class='img-fluid' src='{{ $slider->photo_storage }}' alt="{{ $slider->title }}">
                            <span class="edit-image-hover"><i class="bx bxs-cloud-upload d-block"></i>Изменить</span>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <input class="btn btn-primary btn-block" type="submit" value="Обновить">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <div class="modal ie-scroll-fix" id="modal-slider-add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-dark-light-dm bg-light-lm ">
        <a href="#" class="close" role="button" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <div class="container">

          <div class="row justify-content-center">
            <div class="col-12">
              <h1 class="modal-title font-size-16 text-center">Добавление новой карточки slider</h1>
            </div>
            <div class="col-md-8 col-12">
              <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="title" class="required">Заголовок</label>
                  <input type="text" name="title" id="title" class="form-control" placeholder="Заголовок" required="required" value="{{ old('title') }}">
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-12">
                      <div class="custom-file w-full mb-20">
                        <input type="file"
                               id="photo"
                               class="w-full"
                               name="photo"
                               accept=".jpg,.png">

                        <label for="photo" class="w-full">Выбрать Фотографию</label>
                      </div>
                    </div>
                  </div>
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

  </script>
@endsection
