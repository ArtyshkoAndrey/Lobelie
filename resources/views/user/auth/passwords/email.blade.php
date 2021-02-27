@extends('user.layouts.app')

@section('title', 'DOCKU | Сброс пароля')

@section('content')
  {{--  TODO: Backend part --}}
<div class="container-fluid d-flex align-items-center justify-content-center">
  <div class="row w-100 d-flex justify-content-center">
    <div class="col-lg-5 col-md-6 col-12">
      <div class="row justify-content-center">
        <div class="col-md-5 col-6">
          <img src="{{ asset('images/logo.svg') }}" alt="logo" class="img-fluid mb-5 mx-auto d-block logo">
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
              <h5 class="text-center font-weight-light">Сброс пароля</h5>
            </div>
            <div class="col-12 mt-3">
              <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-outline mb-4">
                  <input type="email" id="email" name="email" class="form-control" />
                  <label class="form-label" for="email">Email</label>
                </div>
                <button id="submitter" class="btn btn-dark w-100 d-block mt-3" style="height: 43px;">Сбросить</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
