@extends('user.layouts.app')
@section('title', 'Личный кабинет')

@section('content')

  <section class="container-fluid px-3 py-5" id="profile">
    <div class="card rounded-0 px-0">
      <div class="card-body px-0 py-0 rounded-0">
        <div class="row mx-0">
          <div class="col-md-3 bg-gray m-0 p-0">
            <div class="nav flex-column nav-pills h-100 m-0" role="tablist" aria-orientation="vertical">
              <a class="nav-link active border-0 rounded-0 py-4" href="{{ route('profile.index') }}" aria-selected="true"><i class="bx bx-user bx-sm pr-1"></i> Мой профиль</a>
              <a class="nav-link border-0 rounded-0 py-4" href="{{ route('order.index') }}" aria-selected="true"><i class="bx bx-list-ol bx-sm pr-1"></i> Мои заказы</a>
            </div>
          </div>
          <div class="col-md-9 p-4">
            <div class="row">
              <div class="col-12">
                <h3 class="font-weight-bold">Мой профиль</h3>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-3">
                <img src="{{ auth()->user()->avatar_image }}" class="img-fluid w-100 px-4 px-md-0" alt="{{ auth()->user()->name }}">
                <form action="{{ route('profile.update.photo') }}" method="POST" id="form-photo" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <input type="file" id="photo" name="photo" size="chars" accept="image/jpeg,image/png" style="visibility: hidden; width: 100px;">
                  <button type="button" class="btn btn-dark position-absolute" id="add-photo">
                    <i class="las la-camera"></i>
                  </button>
                </form>
              </div>
              <div class="col-md-9 pl-md-5 pl-0 px-3 mt-4 mt-md-0">
                <h4 class="font-weight-bold">{{ auth()->user()->name }}</h4>
                <p class="font-weight-light mb-0">{{ auth()->user()->full_address }}</p>
                <p class="font-weight-light mb-0">Валюта: {{ auth()->user()->currency->name ?? '' }}</p>
                <p class="font-weight-light mb-0">{{ auth()->user()->phone }}</p>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-md-4 px-3 px-md-2">
                <div class="row">
                  <div class="col-12">
                    <h4 class="font-weight-bold">Сменить пароль</h4>
                  </div>
                  <div class="col-12">
                    <form action="{{ route('profile.update.password') }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="form-outline form-password mb-4 rounded">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label class="form-label" for="password">Новый пароль</label>
                        <button type="button" class="hide-show-btn" onclick="passwordTypeToggle(this, 'password')"><i class="fas fa-eye"></i></button>
                      </div>
                      <div class="form-outline form-password mb-3">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required/>
                        <label class="form-label" for="password_confirmation">Повторите пароль</label>
                        <button type="button" class="hide-show-btn" onclick="passwordTypeToggle(this, 'password_confirmation')"><i class="fas fa-eye"></i></button>
                      </div>
                      <button type="submit" class="btn btn-dark m-0 shadow-0 rounded-0">Сохранить</button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-8 px-3 px-md-2 mt-4 mt-md-0">
                <div class="row">
                  <div class="col-12">
                    <h4 class="font-weight-bold">Настройки профиля</h4>
                  </div>
                  <div class="col-12">
                    <form action="{{ route('profile.update.data') }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">

                        <div class="col-md-6 col-12">
                          <div class="form-outline mb-4">
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control active"
                                   value="{{ auth()->user()->name }}"
                                   required/>
                            <label class="form-label"
                                   for="name">
                              ФИО
                            </label>
                          </div>
                        </div>

                        <div class="col-md-6 col-12">
                          <div class="form-outline mb-4">
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   class="form-control active"
                                   value="{{ auth()->user()->phone }}"
                                   required/>
                            <label class="form-label"
                                   for="phone">
                              Номер телефона
                            </label>
                          </div>
                        </div>

                        <div class="col-md-6 col-12">
                          <div class="form-outline mb-4">
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control active"
                                   value="{{ auth()->user()->email }}"
                                   required/>
                            <label class="form-label"
                                   for="email">
                              Email
                            </label>
                          </div>
                        </div>

                        <div class="col-md-6 col-12">
                          <select class="form-control mb-4" name="currency">
                            @foreach(\App\Models\Currency::all() as $currency)
                              <option value="{{ $currency->id }}"
                                      {{ ($currency->id === (auth()->user()->currency->id ?? null))
                                            ? 'selected'
                                            : null }} >
                                {{ $currency->name }}
                              </option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-md-6 col-12 mb-4">
                          <country :name="'country'"
                                   :id="'country'"
                                   :country_props="{{ json_encode(auth()->user()->country ?? null) }}">
                          </country>
                        </div>

                        <div class="col-md-6 col-12 mb-4">
                          <city :name="'city'"
                                :id="'city'"
                                :city_props="{{ json_encode(auth()->user()->city ?? null) }}">
                          </city>
                        </div>
                        <div class="col-12 mb-4">
                          <div class="form-outline">
                            <input type="text"
                                   id="address"
                                   name="address"
                                   class="form-control active"
                                   value="{{ auth()->user()->address }}"
                                   required
                            />

                            <label class="form-label"
                                   for="address"
                            >
                              Улица
                            </label>
                          </div>
                          <small class="form-text text-muted">
                            Пример: ул. Ленина, 111 кв. 666
                          </small>
                        </div>

                        <div class="col-12">
                          <div class="form-outline">
                            <input type="text"
                                   id="post_code"
                                   name=post_code
                                   class="form-control active"
                                   value="{{ auth()->user()->post_code }}"
                                   required
                            />

                            <label class="form-label"
                                   for="post_code"
                            >
                              Индекс
                            </label>
                          </div>
                          <small class="form-text text-muted">
                            Пример: 143080
                          </small>
                        </div>
                      </div>

                      <button type="submit"
                              class="btn btn-dark m-0 mt-3 rounded-0 shadow-0">
                        Сохранить
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('js')
  <script>
    $(document).ready(function () {
      $('#add-photo').click(() => {
        $('#photo').click();
      });
      $("#photo").change(() => {
        $('#form-photo').submit()
      })
    })

    $('#phone').mask('+7 (000) 000-00-00');
  </script>
@endsection
