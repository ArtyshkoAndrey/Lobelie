@extends('user.layouts.app')

@section('title', 'DOCKU | Регистрация профиля')

@section('content')
  <div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="row w-100 d-flex justify-content-center">
      <div class="col-lg-4 col-md-5 col-sm-8 col-12">
        <div class="row justify-content-center">
          <div class="col-md-8 col-6">
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="img-fluid mb-2 mx-auto d-block">
          </div>
        </div>
        <div class="card rounded-0">
          <div class="row m-0 flex-nowrap text-center">
            <div class="col-5 col-md-6 bg-gray px-4 px-md-5 py-4 link-inverse-login-register font-weight-bolder">
              <a href="{{ route('login') }}" class="text-decoration-none inverse d-flex justify-content-center align-items-center">
                <i class="bx bx-sm bx-user mr-1"></i>
                Войти
              </a>
            </div>
            <div class="col col-md-6 px-2 px-sm-5 py-4 font-weight-bolder d-flex justify-content-center align-items-center">
              <i class="bx bx-sm bx-plus-circle mr-1"></i>
              Регистрация
            </div>
          </div>
          <div class="card-body p-4">
            <div class="row">
              <div class="col-12 d-none">
                <h5 class="text-center font-weight-light w-100">Регистрация через соц. сеть</h5>
              </div>
              <div class="col-12 d-none">
                <div class="row p-0 m-0">
                  <div class="col-4 p-0 pr-1">
                    <a href="#" class="btn social-signup" id="google">
                      <i class="bx bxl-google mr-md-1"></i>
                      <span class="d-none d-md-block">Google</span>
                    </a>
                  </div>
                  <div class="col-4 p-0 px-1 d-none">
                    <a href="#" class="btn social-signup" id="fb">
                      <i class="bx bxl-facebook mr-md-1"></i>
                      <span class="d-none d-md-block">Facebook</span>
                    </a>
                  </div>
                  <div class="col-4 p-0 pl-1 d-none">
                    <a href="#" class="btn social-signup" id="vk">
                      <i class="bx bxl-vk mr-md-1"></i>
                      <span class="d-none d-md-block">VKontakte</span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-3">
                <h5 class="text-center font-weight-light"><!--Или-->Укажите логин и пароль</h5>
              </div>
              <div class="col-12 mt-3">
                <form action="{{ route('register') }}" method="post">
                  @csrf
                  <div class="form-outline mb-4">
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required/>
                    <label class="form-label" for="name">Имя</label>
                  </div>
                  @error('first_name')
                  <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                  </span>
                  @enderror

                  <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required/>
                    <label class="form-label" for="email">Email</label>
                  </div>
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                  </span>
                  @enderror

                  <div class="form-outline form-password mb-4">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required/>
                    <label class="form-label" for="password">Пароль</label>
                    <button type="button" class="hide-show-btn" onclick="passwordTypeToggle(this, 'password')"><i class="fas fa-eye"></i></button>
                  </div>
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                  </span>
                  @enderror

                  <div class="form-outline form-password mb-4">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required/>
                    <label class="form-label" for="password_confirmation">Повторите пароль</label>
                    <button type="button" class="hide-show-btn" onclick="passwordTypeToggle(this, 'password_confirmation')"><i class="fas fa-eye"></i></button>
                  </div>

                  <button id="submitter" style="height: 43px;" disabled>Зарегистрироваться</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    let checker = {
      name: false,
      password: false,
      password_confirmation: false,
      email: false
    }
    $( "input" ).focus(function() {
      $(this).parent().addClass('focus')
    });
    $('input').focusout(function() {
      $(this).parent().removeClass('focus')
    });
    for (let key in checker) {
      $('#'+key).on('keydown keyup change', function () {
        let charLength = $(this).val().length;
        if (charLength >= 3) {
          checker[key] = true
          console.log(disabled(checker))
          if(disabled(checker)) {
            $('#submitter').attr('disabled', false)
          } else {
            $('#submitter').attr('disabled', true)
          }
        }
      })
    }
    function disabled(checker) {
      let v = true
      for (let key in checker) {
        if (!checker[key]) {
          v = false
        }
      }
      return v
    }
  </script>
@endsection
