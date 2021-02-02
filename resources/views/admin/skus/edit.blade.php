@extends('admin.layouts.app')

@section('title', 'Docku - Редактирова размера $skus->title')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing justify-content-center">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.skus.index') }}">Размеры</a></li>
            <li class="breadcrumb-item">{{ $skus->category->name . ': ' . $skus->title }}</li>
          </ul>
        </nav>
      </div>

      <div class="col-12">
        <div class="card m-0 p-10">
          <div class="row">
            <div class="col-md-6">
              <form action="{{ route('admin.skus.update', $skus) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group {{ $errors->has('title') ? 'is-invalid' : '' }}">
                  <label for="title" class="required">Наименование</label>
                  <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                  </div>
                  <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $skus->title) }}">
                </div>

                <div class="form-group {{ $errors->has('weight') ? 'is-invalid' : '' }}">
                  <label for="weight" class="required">Вес</label>
                  <div class="invalid-feedback">
                    {{ $errors->first('weight') }}
                  </div>
                  <input type="number" class="form-control" name="weight" id="weight" value="{{ old('weight', $skus->weight) }}">
                  <div class="form-text font-size-9 border-0">
                    Если вес будет занятым другим размером, то произойдёт обмен
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Сохранить</button>
              </form>
            </div>
            <div class="col-md-6 pl-md-20 pt-10">
              <ul>
                @foreach($skuses as $sk)
                  <li><a href="{{ route('admin.skus.edit', $sk) }}" class="text-danger">Размер: {{ $sk->title }} <span class="text-white-dm text-dark-lm">Вес: {{ $sk->weight }}</span></a></li>
                @endforeach
              </ul>
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
