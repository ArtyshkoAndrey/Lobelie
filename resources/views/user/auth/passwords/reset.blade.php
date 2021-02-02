@extends('user.layouts.app')

@section('title', 'DOCKU | Изменение пароля')

@section('content')
{{--  TODO: Backend part --}}
  <div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="row w-100 d-flex justify-content-center">
      <div class="col-lg-5 col-md-6 col-12">
        <div class="row justify-content-center">
          <div class="col-md-5 col-6">
            <img src="{{ asset('images/logo-dark.svg') }}" alt="logo" class="img-fluid mb-5 mx-auto d-block logo">
          </div>
        </div>
        @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        @endif
        <div class="card rounded-0">
          <div class="card-body p-4">
            <div class="row">
              <div class="col-12 mt-3">
                <h5 class="text-center font-weight-light">Смена пароля</h5>
              </div>
              <div class="col-12 mt-3">
                <form action="{{ route('password.update') }}" method="post">
                  @csrf
                  <input type="hidden" name="token" value="{{ $token }}">
                  <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" value="{{ old('email', Request::get('email')) }}" class="form-control" />
                    <label class="form-label" for="email">Email</label>
                  </div>
                  <div class="form-outline form-password mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Пароль</label>
                    <button type="button" class="hide-show-btn" onclick="passwordTypeToggle(this, 'password')"><i class="bx bxs-lock-open-alt"></i></button>
                  </div>
                  <div class="form-outline form-password mb-4">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" />
                    <label class="form-label" for="password_confirmation">Повторите пароль</label>
                    <button type="button" class="hide-show-btn" onclick="passwordTypeToggle(this, 'password_confirmation')"><i class="bx bxs-lock-open-alt"></i></button>
                  </div>
                  <button id="submitter" type="submit" class="btn btn-dark w-100 d-block mt-3" style="height: 43px;">Сменить пароль</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
