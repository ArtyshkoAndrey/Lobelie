@extends('user.layouts.app')

@section('title', 'Вход в профиль')

@section('content')
  <div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="row w-100 d-flex justify-content-center">
      <div class="col-lg-4 col-md-5 col-sm-8 col-12">
        <div class="row justify-content-center">
          <div class="col-md-8 col-6">
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="img-fluid mb-2 mx-auto d-block logo">
          </div>
        </div>
        <div class="card rounded-0">
          <div class="row m-0 flex-nowrap text-center">
            <div class="col-4 col-md-6 px-5 py-4 font-weight-bolder d-flex justify-content-center align-items-center">
              <i class="bx bx-sm bx-user mr-1"></i>
              Вход
            </div>
            <div class="col col-md-6 bg-gray px-2 px-sm-4 px-md-5 py-4 font-weight-bolder link-inverse-login-register">
              <a href="{{ route('register') }}" class="text-decoration-none d-flex justify-content-center align-items-center">
                <i class="bx bx-sm bx-plus-circle mr-1"></i>
                Регистрация
              </a>
            </div>
          </div>
          <div class="card-body p-4">
            <div class="row">
              <div class="col-12 d-none">
                <h5 class="text-center font-weight-light w-100">Вход через соц. сеть</h5>
              </div>
              <div class="col-12 d-none">
                <div class="row p-0 m-0">
                  <div class="col-4 p-0 pr-1">
                    <a href="#" class="btn social-signin" id="google">
                      <i class="bx bxl-google mr-md-1"></i>
                      <span class="d-none d-md-block">Google</span>
                    </a>
                  </div>
                  <div class="col-4 p-0 px-1">
                    <a href="#" class="btn social-signin" id="fb">
                      <i class="bx bxl-facebook mr-md-1"></i>
                      <span class="d-none d-md-block">Facebook</span>
                    </a>
                  </div>
                  <div class="col-4 p-0 pl-1">
                    <a href="#" class="btn social-signin" id="vk">
                      <i class="bx bxl-vk mr-md-1"></i>
                      <span class="d-none d-md-block">VKontakte</span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-12 mt-3">
                <h5 class="text-center font-weight-light">Укажите свой логин и пароль</h5>
              </div>
              <div class="col-12 mt-3">
                <form action="{{ route('login') }}" method="post">
                  @csrf
                  <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email</label>
                  </div>
                  <div class="form-outline form-password mb-2">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Пароль</label>
                    <button type="button" class="hide-show-btn" onclick="passwordTypeToggle(this, 'password')"><i class="fas fa-eye"></i></button>
                  </div>
                  <a href="{{ route('password.request') }}">Забыли пароль?</a>
                  <button id="submitter" style="height: 43px;">Войти</button>
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
      password: false,
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
        if (charLength > 3) {
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
