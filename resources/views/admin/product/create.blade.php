@extends('admin.layouts.app')

@section('title', 'Сохрание нового товара')

@section('css')

@endsection

@section('content')

  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Товары</a></li>
            <li class="breadcrumb-item active">Создание товара</li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <h3>Создание товара</h3>
      </div>
      @if ($errors->any())
        <div class="col-12">
          <div class="card bg-dark-dm">
            <div class="invalid-feedback">
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
        <form action="{{ route('admin.product.store') }}" method="POST" class="w-full">
          @csrf
          <div class="row row-eq-spacing p-0 m-0">

            <div class="col-12 col-lg mt-10">
              <div class="card bg-dark-dm">
                <div class="form-group">
                  <label for="title" class="required">Название</label>
                  <input type="text" class="form-control" name="title" id="title" placeholder="Название" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                  <label for="description" class="required">Описание</label>
                  <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                  <label for="meta_title" class="required">Meta Title</label>
                  <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Meta Title" value="{{ old('meta_title') }}" required>
                </div>

                <div class="form-group">
                  <label for="meta_description" class="required">Meta Описание</label>
                  <input type="text" class="form-control" name="meta_description" id="meta_description" placeholder="Meta Описание" value="{{ old('meta_description') }}" required>
                </div>

                <div class="custom-switch d-inline-block mr-10">
                  <input type="hidden" name="on_sale" value="0"><!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                  <input type="checkbox" name="on_sale" id="switch-1" value="1" {{ old('on_sale') ? 'checked' : null }}>
                  <label for="switch-1" class="text-danger">Скидка</label>
                </div>
                <div class="custom-switch d-inline-block mr-10">
                  <input type="hidden" name="on_new" value="0">
                  <input type="checkbox" name="on_new" id="switch-2" value="1" {{ old('on_new') ? 'checked' : null }}>
                  <label for="switch-2" >Новый товар</label>
                </div>
                <div class="custom-switch d-inline-block mr-10">
                  <input type="hidden" name="on_top" value="0"><!-- d-inline-block = display: inline-block, mr-10 = margin-right: 1rem (10px) -->
                  <input type="checkbox" name="on_top" id="switch-3" value="1" {{ old('on_top') ? 'checked' : null }}>
                  <label for="switch-3">Хит продаж</label>
                </div>

              </div>
            </div>

            <div class="col-lg-4 col-12 mt-10">
              <div class="card bg-dark-dm">
                <div class="form-group">
                  <label for="price" class="required">Стоимость</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">₸</span>
                    </div>
                    <input type="number" min="0" class="form-control" name="price" id="price" placeholder="Стоимость" value="{{ old('price') }}" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="price_sale" class="">Скидочная стоимость</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">₸</span>
                    </div>
                    <input type="number" min="0" class="form-control" name="price_sale" id="price_sale" placeholder="Стоимость" value="{{ old('price_sale') }}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="sex" class="required">Пол</label>
                  <div class="input-group">
                    <select name="sex" id="sex" class="form-control" required>
                      @foreach(\App\Models\Product::SEX_MAP as $sex)
                        <option value="{{ $sex }}" {{ old('sex') === $sex ? 'selected' : '' }}>{{ \App\Models\Product::$sexMap[$sex] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="weight" class="required">Вес товара</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">кг.</span>
                    </div>
                    <input type="number" min="0" step="0.01" class="form-control" name="weight" id="weight" placeholder="Вес товара" value="{{ old('weight') }}">
                  </div>
                </div>

                {{-- Поиск по категории --}}
                <category :name="'category'" :id="'category'"></category>

                {{-- Поиск по брендам --}}
                <brand :name="'brand'" :id="'brand'"></brand>


              </div>
            </div>

            <div class="col-12 mt-20">
              <div class="card bg-dark-dm">
                <div class="row" id="skus-wrapper">

{{--                  @foreach($product->productSkuses as $skus)--}}
{{--                    <div class="col-lg-3 col-md-4 col-6 pr-10" id="skus-col-{{ $skus->skus->id }}">--}}
{{--                      <div class="form-group">--}}
{{--                        <label for="skus-{{ $skus->id }}" class="font-weight-bolder">{{ $skus->skus->category->name }}: {{ $skus->skus->title }}</label>--}}
{{--                        <div class="input-group">--}}
{{--                          <input type="number" min="0" step="1" name="skus[{{ $skus->skus->id }}]" id="skus-{{ $skus->id }}" class="form-control" value="{{ $skus->stock ?? null }}">--}}
{{--                          <div class="input-group-append">--}}
{{--                            <button class="btn btn-danger" type="button" onclick="deleteSkus({{ $skus->skus->id }})"><i class="bx bx-x"></i></button>--}}
{{--                          </div>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </div>--}}
{{--                  @endforeach--}}

                </div>

                <div class="row">
                  <a class="btn w-full" href="#modal-skuses" role="button">Добавить размер</a>
                </div>
              </div>
            </div>

            <div class="col-12 mt-20">
              <div class="card bg-dark-dm">
                <div id="upload-widget" class="dropzone"></div>
              </div>
            </div>

            <div class="col-12 mt-10 text-right">
              <button class="btn bg-success">Сохранить</button>
            </div>
          </div>

          @foreach(old('photos', []) as $photo)
            <input type="hidden" id="{{ $photo . '.jpg' }}" value="{{ $photo }}">
          @endforeach
        </form>
      </div>
    </div>
  </div>
@endsection

@section('modal')
  <div class="modal ie-scroll-fix" id="modal-skuses" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content w-600">
        <a href="#" class="close" role="button" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
        <div class="modal-body w-full">
          <div class="row row-eq-spacing m-0 p-0">
            @foreach(\App\Models\SkusCategory::all() as $sk)
              <div class="col-12 m-0 p-0">
                <h5>{{ $sk->name }}</h5>
                @foreach($sk->skuses as $skus)
                  <button id="skus-new-btn-{{$skus->id}}" onclick="addSkus('{{ $sk->name . ': ' . $skus->title }}', '{{ $skus->id }}')" class="btn">{{ $skus->title }}</button>
                @endforeach
              </div>
            @endforeach
          </div>

        </div>

        <div class="modal-footer mt-10 justify-content-end d-flex">
          <a class="btn btn-danger" href="#" role="button" aria-label="Close">Закрыть</a>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('script')
  <script src="https://cdn.tiny.cloud/1/z826n1n5ayf774zeqdphsta5v2rflavdm2kvy7xtmczyokv3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.js"></script>
  <script>
    tinymce.init({
      selector: 'textarea#description',
      plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
      toolbar_mode: 'floating',
    });

    Dropzone.autoDiscover = false;
    let i =0;
    let fileList = [];

    const uploader = new Dropzone('#upload-widget', {
      init: function() {
        // Hack: Add the dropzone class to the element
        $(this.element).addClass("dropzone");
        this.on("success", function (file, serverFileName) {
          fileList[i] = {"serverFileName": serverFileName + '.jpg', "fileName": file.name, "fileId": i};
          $('form').append('<input type="hidden" name="photos[]" id="' + serverFileName + '.jpg" value="' + serverFileName + '">')
          i++;
        });
        this.on("removedfile", function(file) {
          let rmvFile = "";
          for(let f=0;f<fileList.length;f++){
            if(fileList[f].fileName === file.name)
            {
              rmvFile = fileList[f].serverFileName;
            }
          }
          if (rmvFile){
            console.log(rmvFile)
            axios.post("{{ route('admin.product.photo.delete') }}", {
              name: rmvFile
            })
              .then(response => {
                console.log(response)
                console.log('file', document.getElementById(rmvFile).remove());
                document.getElementById(rmvFile).remove()
              })
              .catch(error => {
                alert(error.response.data.status)
              })
          }
        });
      },
      paramName: 'file',
      dictDefaultMessage: 'Переместите фотографии или кликните на поле',
      headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
      },
      acceptedFiles: 'image/*',
      url: "{{ route('admin.product.store.photo') }}",
      renameFile: function (file) {
        return new Date().getTime() + '_' + file.name;
      },
      addRemoveLinks: true,
      dictRemoveFile: 'Удалить файл'
    });

    function addSkus(name, id) {
      console.log(name, id)
      let row = document.getElementById('skus-wrapper')
      let col = document.createElement('div')
      let idBtn = '#skus-new-btn-' + id
      let btn = $(idBtn)
      btn.attr("disabled", 'disabled');
      btn.addClass('btn-success')
      col.classList.add('col-lg-3')
      col.classList.add('col-md-4')
      col.classList.add('col-6')
      col.classList.add('pr-10')
      col.id = 'skus-col-' + id

      let form_group = document.createElement('div')
      form_group.classList.add('form-group')

      let label = document.createElement('label')
      label.setAttribute('for', 'skus-new-' + id)
      label.textContent = name

      // let input = document.createElement('input')
      // input.classList.add('form-control')
      // input.type = 'number'
      // input.min = '0'
      // input.step = '1'
      // input.name = 'skus[' + id + ']'

      let input = '<input class="form-control" value="0" min="0" step="1" name="skus[' + id + ']">'

      let input_group = document.createElement('div')
      input_group.classList.add('input-group')

      input_group.innerHTML += input

      form_group.appendChild(label)
      form_group.appendChild(input_group)
      input_group.innerHTML += ('<div class="input-group-append"> <button class="btn btn-danger" type="button" onclick="deleteSkus(' + id +')"><i class="bx bx-x"></i></button> </div>')

      col.appendChild(form_group)
      row.appendChild(col)

      // $('.close')[0].click()
    }

    function deleteSkus (id) {
      document.getElementById('skus-col-' + id).remove()
      let idBtn = '#skus-new-btn-' + id
      let btn = $(idBtn)
      btn.attr("disabled", false)
      btn.removeClass('btn-success')

    }

    $(document).ready(function() {
      <?php $i = 0;?>
      let mockFile
      @foreach(old('photos', []) as $photo)
        mockFile = { name: '{{ $photo . '.jpg' }}', size: {{ File::size(public_path('storage/images/photos/' . $photo . '.jpg')) }} };
        uploader.emit("addedfile", mockFile);
        uploader.emit("thumbnail", mockFile, '{{ asset('storage/images/thumbnails/' . $photo . '.jpg') }}');
        uploader.emit("complete", mockFile);
        uploader.files.push(mockFile)
        fileList.push({"serverFileName": '{{ $photo . '.jpg' }}', "fileName":'{{ $photo . '.jpg' }}', "fileId": {{ $i }}});
        <?php $i++?>
      @endforeach
    });
  </script>
@endsection
