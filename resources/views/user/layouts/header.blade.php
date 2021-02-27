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
            <a class="nav-link" href="{{ route('profile.favorites') }}">
              <i class="fal fa-heart"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link position-relative cart-open-button active" onclick="toggleCart()">
              <i class="las la-shopping-bag"></i>
              <span class="badge rounded-pill badge-notification bg-dark text-light">@{{ $store.state.cart.items.reduce((a, b) => +a + +b.amount, 0) }}</span>
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
              <a class="nav-link" href="{{ route('profile.favorites') }}">
                <i class="fal fa-heart"></i>
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <div class="container-fluid category-menu">
        <div class="row">
          @widget('category-menu')
        </div>
      </div>
    </div>
  </div>
  <div id="cart">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-6">
          <h2>Корзина</h2>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
          <a href="#!" onclick="event.stopPropagation();" @click="$store.commit('clearCart')">Очистить корзину</a>
        </div>
      </div>
      <div class="row pb-3" v-for="product in $store.getters.productsCart" v-if="product">

        <div class="col-3">
          <img :src="product.thumbnail_jpg" alt="" class="img-fluid">
        </div>
        <div class="col-9">
          <div class="row h-100">
            <div class="col-7">
              <div class="row h-100">
                <div class="col-12">
                  <h5 class="item-title">@{{ product.title }} - @{{ product.skus.skus.title }}</h5>
                </div>
                <div class="col-12 d-flex align-items-end">
                  <h4 class="item-price mb-0">@{{ $cost( (product.on_sale ? product.price_sale : product.price) * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</h4>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="row h-100">
                <div class="col-12 d-flex justify-content-end">
                  <a href="#!" @click="$store.commit('removeItem', product.item.id)">Удалить</a>
                </div>
                <div class="col-12 d-flex align-items-end justify-content-end">
                  <div class="buttons-wrapper">
                    <button class="cart-button"  @click="$store.commit('addItem', {id: product.item.id, amount: -1 })">-</button>
                    <span class="font-tenor mx-2">@{{ product.item.amount }}</span>
                    <button class="cart-button" @click="$store.commit('addItem', {id: product.item.id, amount: 1 })">+</button>
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
          <span>@{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</span>
        </div>
        <div class="col-12 col-sm-6 d-flex align-items-center justify-content-end">
          <a class="btn btn-dark" href="{{ route('cart.index') }}">Оформить заказ</a>
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
          <form action="{{ route('product.search') }}" method="GET">
            <div class="row d-flex">
              <div class="col-12 col-md-9">
                <div class="search-input-wrapper">
                  <input class="search-input pr-4 pr-md-0" name="q" id="q" placeholder="Поиск украшений...">
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
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
