<div class="header lato">
  <div class="container-fluid m-0 p-0">
    <nav id="main-menu" class="navbar navbar-expand">
      <div class="navbar-collapse collapse align-items-center justify-content-center" id="navbarSupportedContent">
        <ul class="navbar-nav w-100">
          <li class="nav-item">
            <div id="nav-toggle">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </li>
          <li class="nav-item search d-none d-md-block">
            <a class="nav-link" onclick="toggleSearch()">
              <i class="las la-search" style="font-size: 1.2em;"></i>
            </a>
          </li>
          <li class="nav-item dropdown currency-dropdown d-none d-md-block">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-mdb-toggle="dropdown"
              aria-expanded="false"
            >
              <span class="">@{{ $store.state.currency.short_name ?? 'Загрузка' }}</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach(\App\Models\Currency::all() as $currency)
                <li>

                  <button
                    @click="$store.dispatch('set_currency', { currency: {{$currency}} })"
                    class="dropdown-item"
                    v-bind:class="$store.state.currency.id === {{ $currency->id }} ? 'active' : '' ">
                    {{ $currency->short_name }}
                  </button>

                </li>
              @endforeach
            </ul>
          </li>
          <li class="nav-item  mx-auto">
            <a class="" href="{{ route('index') }}">
              <img class="logo" src="{{ asset('images/logo.svg') }}" alt="logo">
            </a>
          </li>
          @include('user.layouts.login_item')
          <li class="divider d-none d-md-block"></li>
          <li class="nav-item d-none d-md-block">
            <a class="nav-link" onclick="">
              <i class="fal fa-heart"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link position-relative cart-open-button active" onclick="toggleCart()">
              <i class="las la-shopping-bag"></i>
              <span class="badge rounded-pill badge-notification bg-dark text-light">0</span>
            </a>
            <a class="nav-link position-relative cart-close-button" onclick="toggleCart()">
              <i class="las la-times"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <div id="menu-dropdown-page">
      <nav class="navbar navbar-expand d-block d-md-none">
        <div class="navbar-collapse collapse align-items-center justify-content-center" id="navbarSupportedContent">

          <ul class="navbar-nav w-100">
            {{--            TODO: Валюта --}}
            <li class="nav-item dropdown currency-dropdown mr-auto">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-mdb-toggle="dropdown"
                aria-expanded="false"
              >
                <span class="">@{{ $store.state.currency.short_name ?? 'Загрузка' }}</span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach(\App\Models\Currency::all() as $currency)
                  <li>

                    <button
                      @click="$store.dispatch('set_currency', { currency: {{$currency}} })"
                      class="dropdown-item"
                      v-bind:class="$store.state.currency.id === {{ $currency->id }} ? 'active' : '' ">
                      {{ $currency->short_name }}
                    </button>

                  </li>
                @endforeach
              </ul>
            </li>
            {{--            TODO: Войти --}}

            @include('user.layouts.login_item')
            <div class="divider"></div>
            {{--            TODO: Поиск --}}
            <li class="nav-item">
              <a class="nav-link" onclick="toggleSearch()">
                <i class="las la-search"></i>
              </a>
            </li>
            {{--            TODO: Сердечко --}}
            <li class="nav-item">
              <a class="nav-link" onclick="">
                <i class="fal fa-heart"></i>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container-fluid category-menu">
        <div class="row">
          <div class="col-12 col-md-6 col-lg-4 d-flex flex-column" v-for="i in 3">
            <div class="row category" v-for="i in 3">
              <div class="col-6 d-flex flex-column">
                <h4>Мужчинам</h4>
                <a href="#!">Кольца</a>
                <a href="#!">Перстни</a>
                <a href="#!">Браслеты</a>
                <a href="#!">Цепочки</a>
              </div>
              <div class="col-6">
                <a href="#!" class="see-all">Смотреть все</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="cart">
    <div class="container-fluid p-3">
      <div class="row mb-2">
        <div class="col-6">
          <h2>Корзина</h2>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
          <a href="#!">Очистить корзину</a>
        </div>
      </div>
      <div class="row pb-3" v-for="i in 7">
        <div class="col-3">
          <img src="{{ asset('images/product.png') }}" alt=""
               class="img-fluid" style="border-radius: 6px;">
        </div>
        <div class="col-9">
          <div class="row h-100">
            <div class="col-7">
              <div class="row h-100">
                <div class="col-12">
                  <h5 class="item-title">Полное название товара</h5>
                </div>
                <div class="col-12 d-flex align-items-end">
                  <h4 class="item-price mb-0">10 000</h4>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="row h-100">
                <div class="col-12 d-flex justify-content-end">
                  <a href="#!">Удалить</a>
                </div>
                <div class="col-12 d-flex align-items-end justify-content-end">
                  <div class="buttons-wrapper">
                    <button class="cart-button" onclick="">-</button>
                    <span class="font-tenor mx-2">1</span>
                    <button class="cart-button" onclick="">+</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid price-result-wrapper">
      <div class="row h-100">
        <div class="col-12 col-sm-6 d-flex align-items-center">
          <span class="mr-2">Итого:</span>
          <span>40 000 ₸</span>
        </div>
        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-end">
          <button class="btn btn-dark">Оформить заказ</button>
        </div>
      </div>
    </div>
  </div>
  <div id="search">
    <div class="container-fluid h-100 p-2">
      <div class="row justify-content-center h-100">
        <div class="col-12 d-flex justify-content-start justify-content-md-end">
          <button class="close-search" onclick="toggleSearch()">
            <i class="las la-times"></i>
          </button>
        </div>
        <div
          class="col-12 col-md-8 d-flex flex-column justify-content-start justify-content-md-center h-100 pl-4 pl-md-3"
          style="padding-bottom: 6em;">
          <h1 class="w-100 text-dark text-left text-md-center mb-4">Что бы вы хотели найти?</h1>
          <div class="row d-flex">
            <div class="col-12 col-md-9">
              <div class="search-input-wrapper">
                <input class="search-input pr-4 pr-md-0" placeholder="Поиск украшений...">
                <i class="las la-search d-block d-md-none"></i>
              </div>
            </div>
            <div class="col-3 d-none d-md-flex">
              <button class="search-button" type="submit">
                <i class="las la-search"></i>
                <span>Найти</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
