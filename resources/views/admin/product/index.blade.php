@extends('admin.layouts.app')

@section('title', 'Список товаров')

@section('content')
  <div class="container-fluid mt-20 mb-20">
      <div class="row px-20 justify-content-center">
        <div class="col-12">
          <nav aria-label="Breadcrumb navigation example">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active"><a href="#">Товары</a></li>
              <li class="breadcrumb-item"></li>
            </ul>
          </nav>
        </div>
        <div class="col-12">
          <div class="row align-items-center">
            <div class="col-auto">
              <h3>Товары</h3>
            </div>
            <div class="col-auto px-10">
              <a href="{{ route('admin.product.create') }}" class="btn">Создать новый товар</a>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="card m-0 p-10 bg-dark-dm">
            <a href="{{ route('admin.product.index', ['type' => 'all']) }}" class="mr-10 {{ $filter['type'] === 'all' ? 'text-danger' : 'text-white' }}">Все товары ({{ \App\Models\Product::withTrashed()->count() }})</a>
            <a href="{{ route('admin.product.index', ['type' => 'isset']) }}" class="mr-10 {{ $filter['type'] === 'isset' ? 'text-danger' : 'text-white' }}">В продаже ({{ \App\Models\Product::count() }})</a>
            <a href="{{ route('admin.product.index', ['type' => 'deleted']) }}" class="mr-10 {{ $filter['type'] === 'deleted' ? 'text-danger' : 'text-white' }}">Удалённые ({{ \App\Models\Product::onlyTrashed()->count() }})</a>
          </div>
        </div>

        <div class="col col-md mb-20 mt-10 pr-10">
          <form action="{{ route('admin.product.index') }}" method="get">
            <div class="input-group">
              <label for="name"></label>
              <input value="{{ $filter['name'] }}" type="text" name="name" id="name" placeholder="Поиск по имени" class="form-control shadow-none border-none" required>
              <input type="hidden" name="type" value="{{ $filter['type'] }}">
              <div class="input-group-append">
                <button class="btn rounded-right shadow-none border-none">
                  <i class="bx bx-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>

        <div class="col-md-auto mt-10 col-auto">
          <a href="{{ route('admin.product.index') }}" class="btn">Сбросить</a>
        </div>

        <div class="col-12">
          <div class="row">
            <div class="col-md">
              {{ $products->links('vendor.pagination.halfmoon') }}
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row align-items-stretch row-eq-spacing justify-content-center justify-content-md-start px-0 m-0">
            @forelse($products as $product)
              <div class="col-11 col-md-6 col-lg-3 mt-20 d-block d-lg-none">
                <div class="card h-full m-0 p-0 bg-dark-dm">
                  <img src="{{ $product->thumbnail_jpg  }}" class="img-fluid rounded-top h-150 w-full object-fit-cover" alt="...">
                  <div class="content mx-20 mt-0">
                    <div class="content-title my-20">
                      {{ $product->title }}
                      @if($product->trashed())
                        <p class="text-danger font-size-12 m-0">Удалено</p>
                      @endif
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <span class="text-muted">Количество</span>
                        <p class="m-0">{{ $product->skuses->sum('pivot.stock')  }} шт.</p>
                      </div>
                      <div class="col-6">
                        <span class="text-muted">Стоимость</span>
                        <p class="m-0">{{ number_format((int) $product->price, 0, ',', ' ') }}  ₸</p>
                      </div>

                      <div class="col-6 mt-10">
                        <span class="text-muted">Продаж</span>
                        <p class="m-0">{{ $product->orders->sum('pivot.amount') }} шт.</p>
                      </div>
                      @if(!$product->trashed())
                        <div class="col-12 mt-10 h-full">
                          <form action="{{ route('admin.product.destroy', $product) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger d-block w-full text-center"><i class="bx bx-trash"></i></button>
                          </form>
                        </div>
                      @else
                        <div class="col-12 mt-10 h-full">
                          <form action="{{ route('admin.product.destroy', $product) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-success d-block w-full text-center"><i class="bx bxs-plus-circle"></i></button>
                          </form>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-12 mt-10 d-lg-block d-none">
                <div class="card border-0 product p-0 m-0 bg-dark-dm">
                  <div class="row py-10 align-items-center row-eq-spacing p-0 m-0">
                    <div class="col-lg-1 col-5 px-10 overflow-hidden">
                      <img src="{{ $product->thumbnail_jpg }}" class="h-auto d-flex w-full rounded m-0 p-0" alt="{{ $product->title }}">
                    </div>
                    <div class="col-lg col">
                      <div class="row align-items-start">
                        <a href="{{ route('admin.product.edit', $product) }}" class="d-block text-decoration-none pr-10 pl-0 col-12 col-lg-6 align-self-center">
                          <p class="text-muted font-weight-bolder m-0 font-size-12">Наименование</p>
                          <p class="font-weight-bold m-0 font-size-14 link-product">{{ $product->title  }}</p>
                          @if($product->trashed())
                            <p class="text-danger font-size-12 m-0">Удалено</p>
                          @endif
                        </a>

                        <div class="col col-lg">
                          <p class="text-muted font-weight-bolder m-0 font-size-12">Кол-во</p>
                          <p class="font-weight-bold {{ $product->skuses->sum('pivot.stock') > 0 ? 'text-white-dm' : 'text-danger' }} m-0 font-size-14">{{ $product->skuses->sum('pivot.stock')  }} шт.</p>
                        </div>

                        <div class="col col-lg">
                          <p class="text-muted font-weight-bolder m-0 font-size-12">Стоимость</p>
                          <p class="font-weight-bold text-white-dm m-0 font-size-14">{{ number_format($product->price, 0, ',', ' ') }} ₸</p>
                        </div>

                        <div class="col-12 col-lg">
                          <p class="text-muted font-weight-bolder m-0 font-size-12">Продаж</p>
                          <p class="font-weight-bold text-white-dm m-0 font-size-14">{{ $product->orders->sum('pivot.amount') }} шт.</p>
                        </div>
                        @if(!$product->trashed())
                          <div class="col-12 col-lg align-self-center border-left">
                            <form action="{{ route('admin.product.destroy', $product) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" style="z-index: 1000" class="btn bg-transparent d-none d-lg-block shadow-none text-danger border-0"><i class="bx font-size-18 bxs-trash"></i></button>
                              </form>
                          </div>
                        @else
                          <div class="col-12 col-lg align-self-center border-left">
                            <form action="{{ route('admin.product.destroy', $product) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn bg-transparent shadow-none d-none d-lg-block text-success border-0"><i class="bx font-size-18 bxs-plus-circle"></i></button>
                            </form>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            @empty
              <div class="col-12">
                <h4 class="text-center">Нет товаров</h4>
              </div>
            @endforelse

          </div>
        </div>

      </div>
    </div>
@endsection

@section('script')
@endsection
