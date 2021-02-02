@extends('admin.layouts.app')

@section('title', 'Docku - Список промокодов')

@section('content')
  <div class="container-fluid mt-20 mb-20">
    <div class="row row-eq-spacing justify-content-center">
      <div class="col-12">
        <nav aria-label="Breadcrumb navigation example">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active"><a href="#">Промокоды</a></li>
            <li class="breadcrumb-item"></li>
          </ul>
        </nav>
      </div>
      <div class="col-12">
        <div class="row align-items-center">
          <div class="col-auto">
            <h3>Промокоды</h3>
          </div>

          <div class="col-md-auto col-12 mt-10 mt-md-0 px-10">
            <a href="{{ route('admin.coupon.create') }}" class="btn d-block">Создать новый промокод</a>
          </div>

        </div>
      </div>

      <div class="col-12">
        <div class="row" style="margin-left: -1rem; margin-right: -1rem ;">
          @foreach($coupons as $cp)
            <div class="col-12 col-md-12 col-xl-6 p-10">
              <div class="card p-10 bg-dark-dm m-0">
                <div class="row align-items-center">
                  <div class="col-auto col-md-auto">
                    <a href="{{ route('admin.coupon.edit', $cp->id) }}" class="text-decoration-none m-0 p-0 {{ $cp->enabled ? 'text-success' : 'text-danger' }}">
                      <h5 class="p-0 m-0 d-block">{{ $cp->code }}</h5>
                    </a>
                  </div>
                  <div class="col-md-auto col-auto pl-10">
                    <span>{{$cp->not_before->format('d.m.y')}} - {{$cp->not_after->format('d.m.y')}}</span>
                  </div>

                  <div class="col-md-auto col-auto pl-10">
                    <span>{{ (int)$cp->value }} {{ $cp->type === \App\Models\CouponCode::TYPE_PERCENT ? ' %' : ' тг.' }}</span>
                  </div>

                  <div class="col-lg col-12">
                    <div class="row justify-content-end">
                      <div class="col-md-auto col-6 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <a href="{{ route('admin.coupon.edit', $cp->id) }}" class="btn bg-transparent text-success shadow-none border-0 d-block"><i class="bx bx-pencil font-size-16"></i></a>
                      </div>
                      <div class="col-md-auto col-6 pl-10 mt-10 mt-lg-0 mt-md-10">
                        <form action="{{ route('admin.coupon.destroy', $cp->id) }}" method="POST">
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


@section('script')

@endsection
