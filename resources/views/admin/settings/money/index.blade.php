@extends('admin.layouts.app')

@section('title', 'Docku - Настройки оплаты')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">Настройки оплаты</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Настройки оплаты</h3>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          <div class="col-6 col-md-4 mt-10 px-10">
            <div class="card p-10 bg-dark-dm m-0">
              <form action="{{ route('admin.settings.money.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="custom-switch">
                  <input type="checkbox" name="cash" id="cash" {{ $cash->data === '1' ? 'checked' : null }} value="true">
                  <label for="cash">Наличные</label>
                </div>

                <div class="custom-switch mt-10">
                  <input type="checkbox" name="cloudPayment" id="cloudPayment" {{ $cloudPayment->data === '1' ? 'checked' : null }} value="true">
                  <label for="cloudPayment">CloudPayment</label>
                </div>

                <button type="submit" class="btn mt-10">Сохранить</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection

