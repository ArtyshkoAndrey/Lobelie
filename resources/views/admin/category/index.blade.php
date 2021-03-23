@extends('admin.layouts.app')

@section('title', 'Список категорий')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item {{ count($categoriesLink) < 1 ? 'active' : '' }}"><a href="{{ route('admin.category.index') }}">Виды изделий</a></li>
            @foreach($categoriesLink as $index => $ct)
              <li class="breadcrumb-item {{ $index === count($categoriesLink) - 1 ? 'active' : '' }}"><a href="{{ route('admin.category.index', ['category_id' => $ct->id]) }}">{{ $ct->name }}</a></li>
            @endforeach
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>{{ $ct->name ?? 'Виды изделий' }}</h3>
          </div>

          @if(count($categoriesLink) < 3)
            <div class="col-auto px-10">
              <a href="#modal-category-add" class="btn d-block">Создать новый вид изделия</a>
            </div>
          @endif

        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($categories as $category)
            <div class="col-12 mt-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-md-1 pr-10">
                    <img src="{{ $category->photo_storage }}" class="img-fluid rounded" alt="{{ $category->name }}">
                  </div>
                  <div class="col-4 col-md-4 col-lg-auto">
                    @if(count($categoriesLink) < 1)
                      <a href="{{ route('admin.category.index', ['category_id' => $category->id]) }}" class="text-decoration-none text-danger m-0 p-0">
                        <h5 class="p-0 m-0 d-block">{{ $category->name }}</h5>
                      </a>
                    @else
                      <h5 class="text-decoration-none text-danger m-0 p-0">{{ $category->name }}</h5>
                    @endif
                    @if($category->to_menu)
                      <p class="text-danger m-0">На главной странице</p>
                    @endif
                  </div>

                  <div class="col-md col">
                    <div class="row justify-content-center">

                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10 ml-lg-auto">
                        <a href="#modal-category-{{ $category->id }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                      </div>
                      <div class="col-md-10 col-lg-auto col-4 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST">
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

  @foreach($categories as $category)
    <div class="modal ie-scroll-fix" id="modal-category-{{$category->id}}" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark-light-dm bg-light-lm ">
          <a href="#" class="close" role="button" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
          <div class="container">

            <div class="row justify-content-center">
              <div class="col-12">
                <h1 class="modal-title font-size-16 text-center">Обновление вида изделий</h1>
              </div>
              <div class="col-md-8 col-12">
                <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="form-group">
                    <label for="name" class="required">Наименование</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Наименование" required="required" value="{{ old('name', $category->name) }}">
                  </div>

                  <div class="form-group">
                    <label for="category_id">Родительскай вид изделий</label>
                    <select name="category_id" id="category_id" class="form-control">
                      <option value="">Без родиельского вида изделий</option>
                      @foreach(\App\Models\Category::all() as $categoryForm)
                        @if($category->id !== $categoryForm->id)
                          <option value="{{ $categoryForm->id }}" {{ ($category->parents()->first()->id ?? 0) === $categoryForm->id ? 'selected' : '' }}>{{ $categoryForm->name }}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-6 mr-10">
                        <div class="custom-file mb-20">
                          <label class="required bg-transparent disabled p-0 shadow-none border-0">Фотография</label>
                          <input type="file"
                                 id="photo-{{ $category->id }}"
                                 class="w-full"
                                 name="photo"
                                 value="{{ $category->photo }}"
                                 accept=".jpg,.png">

                          <div class="wrapper-hover-image" onclick="$('#photo-{{ $category->id }}').click()">
                            <img class='img-fluid' src='{{ $category->photo_storage }}' alt="{{ $category->name }}">
                            <span class="edit-image-hover"><i class="bx bxs-cloud-upload d-block"></i>Изменить</span>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="to_menu" value="0">
                    <div class="custom-switch d-inline-block mr-10"> <!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                      <input type="checkbox" id="to_menu-{{ $category->id }}" name="to_menu" value="1" {{ $category->to_menu ? 'checked' : null }}>
                      <label for="to_menu-{{ $category->id }}">На главный экран</label>
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

  <div class="modal ie-scroll-fix" id="modal-category-add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content bg-dark-light-dm bg-light-lm ">
        <a href="#" class="close" role="button" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <div class="container">

          <div class="row justify-content-center">
            <div class="col-12">
              <h1 class="modal-title font-size-16 text-center">Добавление нового вида изделий</h1>
            </div>
            <div class="col-md-8 col-12">
              <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="name" class="required">Наименование</label>
                  <input type="text" name="name" id="name" class="form-control" placeholder="Наименование" required="required" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                  <label for="category_id">Родительскай вид изделий</label>
                  <select name="category_id" id="category_id" class="form-control">
                    <option value="null">Без родительского вида изделий</option>
                    @foreach(\App\Models\Category::all() as $category)
                      <option value="{{ $category->id }}" {{ (end($categoriesLink)->id ?? 0) === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
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
                <div class="form-group">
                  <input type="hidden" name="to_menu" value="0">
                  <div class="custom-switch d-inline-block mr-10"> <!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                    <input type="checkbox" name="to_menu" id="to_menu-create" value="1" {{ old('to_menu') ? 'checked' : null }}>
                    <label for="to_menu-create">На главный экран</label>
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
