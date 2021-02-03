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
          <li class="nav-item">
            <a class="nav-link" onclick="">
              <i class="las la-shopping-bag"></i>
              <span class="badge rounded-pill badge-notification bg-dark text-light">0</span>
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
  <div id="search">
    <div class="container-fluid h-100 p-2">
      <div class="row justify-content-center h-100">
        <div class="col-12 d-flex justify-content-start justify-content-md-end">
          <button class="close-search" onclick="toggleSearch()">
            <i class="las la-times"></i>
          </button>
        </div>
        <div class="col-12 col-md-8 d-flex flex-column justify-content-start justify-content-md-center h-100 pl-4 pl-md-0"
             style="padding-bottom: 6em;">
          <h1 class="w-100 text-dark text-left text-md-center mb-4">Что бы вы хотели найти?</h1>
          <div class="row d-flex">
            <div class="col-12 col-md-9">
              <div class="search-input-wrapper">
                <input class="search-input" placeholder="Поиск украшений...">
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
{{--  <nav id="main-menu" class="navbar navbar-expand">--}}
{{--    <div class="container">--}}
{{--      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">--}}
{{--        <ul class="navbar-nav align-items-center w-100">--}}
{{--          <li class="nav-item dropdown mr-auto">--}}
{{--            <a--}}
{{--              class="nav-link dropdown-toggle"--}}
{{--              href="#"--}}
{{--              id="navbarDropdown"--}}
{{--              role="button"--}}
{{--              data-mdb-toggle="dropdown"--}}
{{--              aria-expanded="false"--}}
{{--            >--}}
{{--              <span class="">@{{ $store.state.currency.short_name ?? 'Загрузка' }}</span>--}}
{{--            </a>--}}
{{--            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--              @foreach(\App\Models\Currency::all() as $currency)--}}
{{--                <li>--}}

{{--                  <button--}}
{{--                    @click="$store.dispatch('set_currency', { currency: {{$currency}} })"--}}
{{--                    class="dropdown-item"--}}
{{--                    v-bind:class="$store.state.currency.id === {{ $currency->id }} ? 'active' : '' ">--}}
{{--                      {{ $currency->name }} ({{ $currency->symbol }})--}}
{{--                  </button>--}}

{{--                </li>--}}
{{--              @endforeach--}}
{{--            </ul>--}}
{{--          </li>--}}
{{--          <li class="nav-item d-none d-xl-flex">--}}
{{--            <a href="tel:+77475562383" class="d-block nav-link">+7 (747) 556-23-83</a>--}}
{{--          </li>--}}
{{--          <li class="nav-item d-none d-md-flex mx-auto">--}}
{{--            <a class="" href="{{ route('index') }}">--}}
{{--              <img class="light-logo" src="{{ asset('images/logo.svg') }}" alt="logo">--}}
{{--              <img class="dark-logo" src="{{ asset('images/logo-dark.svg') }}" alt="logo">--}}
{{--            </a>--}}
{{--          </li>--}}
{{--          <li class="d-none d-lg-flex">--}}
{{--            <a class="nav-link" href="mailto:info@dockuboardhouse.com">info@dockuboardhouse.com</a>--}}
{{--          </li>--}}
{{--          <li class="nav-item icon ml-auto ml-md-0">--}}
{{--              <a class="nav-link" onclick="toggleSearch()">--}}
{{--                <i class="bx bx-sm bx-search"></i>--}}
{{--              </a>--}}
{{--            </li>--}}
{{--          <li class="nav-item icon dropdown">--}}
{{--              <a--}}
{{--                class="nav-link"--}}
{{--                href="#"--}}
{{--                id="user-dropdown"--}}
{{--                role="button"--}}
{{--                data-mdb-toggle="dropdown"--}}
{{--                aria-expanded="false"--}}
{{--              >--}}
{{--                <i class="bx bx-sm bx-user"></i>--}}
{{--              </a>--}}
{{--              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="user-dropdown">--}}
{{--                <div class="row">--}}
{{--                  <div class="col-12">--}}
{{--                    @auth--}}
{{--                      <div class="row">--}}
{{--                        <a href="{{ route('profile.index') }}" class="d-flex dropdown-item">--}}
{{--                          <div class="col-2 d-flex align-items-center justify-content-center">--}}
{{--                            <img class="rounded-circle"--}}
{{--                                 src="{{ auth()->user()->avatar_image }}"--}}
{{--                                 style="width: 25px; height: 25px;" alt="logo"/>--}}
{{--                          </div>--}}
{{--                          <div class="col-auto mx-2">--}}
{{--                            {{ auth()->user()->name }}--}}
{{--                          </div>--}}
{{--                        </a>--}}
{{--                      </div>--}}
{{--                      @if(auth()->user()->is_admin)--}}
{{--                      <div class="row">--}}
{{--                        <a href="{{ route('admin.index') }}" class="d-flex dropdown-item">--}}
{{--                          <div class="col-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bx bx-sm bxs-dashboard"></i>--}}
{{--                          </div>--}}
{{--                          <div class="col-auto mx-2">--}}
{{--                            Администитивная панель--}}
{{--                          </div>--}}
{{--                        </a>--}}
{{--                      </div>--}}
{{--                      @endif--}}
{{--                      <div class="row">--}}
{{--                        <a href="#" class="d-flex dropdown-item" onclick="event.preventDefault();$('#logout').submit()">--}}
{{--                          <div class="col-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bx bx-sm bx-log-out"></i>--}}
{{--                          </div>--}}
{{--                          <div class="col-auto mx-2">--}}
{{--                            Выйти--}}
{{--                          </div>--}}
{{--                        </a>--}}
{{--                        <form action="{{ route('logout') }}" id="logout" method="POST" class="d-none">--}}
{{--                          @csrf--}}
{{--                        </form>--}}
{{--                      </div>--}}
{{--                    @else--}}
{{--                      <div class="row">--}}
{{--                        <a href="{{ route('login') }}" class="d-flex dropdown-item">--}}
{{--                          <div class="col-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bx bx-sm bx-user"></i>--}}
{{--                          </div>--}}
{{--                          <div class="col-auto mx-2">--}}
{{--                            Войти--}}
{{--                          </div>--}}
{{--                        </a>--}}
{{--                      </div>--}}
{{--                      <div class="row">--}}
{{--                        <a href="{{ route('register') }}" class="d-flex dropdown-item">--}}
{{--                          <div class="col-2 d-flex align-items-center justify-content-center">--}}
{{--                            <i class="bx bx-sm bx-plus-circle"></i>--}}
{{--                          </div>--}}
{{--                          <div class="col-auto mx-2">--}}
{{--                            Зарегистрироваться--}}
{{--                          </div>--}}
{{--                        </a>--}}
{{--                      </div>--}}
{{--                      @endauth--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </li>--}}
{{--          <li class="nav-item icon dropdown">--}}
{{--            <a--}}
{{--              class="nav-link position-relative"--}}
{{--              href="#"--}}
{{--              id="cart-dropdown"--}}
{{--              role="button"--}}
{{--              data-mdb-toggle="dropdown"--}}
{{--              aria-expanded="false"--}}
{{--            >--}}
{{--              <i class="bx bx-sm bx-cart"></i>--}}
{{--              <span class="badge rounded-pill badge-notification bg-white text-black">@{{ $store.state.cart.items.reduce((a, b) => +a + +b.amount, 0) }}</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu full-height dropdown-menu-end" aria-labelledby="cart-dropdown">--}}

{{--              <div class="row ml-0 mb-2" v-for="product in $store.getters.productsCart" v-if="product">--}}
{{--                <div class="col-3 col-sm-2 d-flex align-items-start p-0 pb-2">--}}
{{--                  <img :src="product.thumbnail_jpg" alt="" class="img-fluid" style="border-radius: 6px;">--}}
{{--                </div>--}}
{{--                <div class="col-9 col-sm-10">--}}
{{--                  <div class="row align-items-center justify-content-between h-100 pb-2 pb-md-0">--}}
{{--                    <div class="col-6 col-sm-5 order-1 d-flex align-self-stretch align-self-sm-auto">--}}
{{--                      <p class="m-0 font-weight-bold">@{{ product.title }} -  @{{ product.skus.skus.title }}</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-7 col-sm-auto order-3 order-sm-2 ml-sm-auto mt-auto mt-sm-0">--}}
{{--                      <p class="m-0" style="font-size: 1.3em;">--}}
{{--                        @{{ $cost( (product.on_sale ? product.price_sale : product.price) * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}--}}
{{--                      </p>--}}
{{--                    </div>--}}
{{--                    <div class="col-5 col-sm-auto order-4 order-sm-3 d-flex justify-content-between align-items-center mt-auto mt-sm-0">--}}
{{--                      <button type="button" class="btn btn-dark cart-button" onclick="event.stopPropagation();" @click="$store.commit('addItem', {id: product.item.id, amount: -1 })">--}}
{{--                        <i class="bx bx-minus"></i>--}}
{{--                      </button>--}}
{{--                      <p id="cart-item-amount-1" class="mx-2 my-auto">--}}
{{--                        @{{ product.item.amount }}--}}
{{--                      </p>--}}
{{--                      <button type="button" class="btn btn-dark cart-button" onclick="event.stopPropagation();" @click="$store.commit('addItem', {id: product.item.id, amount: 1 })">--}}
{{--                        <i class="bx bx-plus"></i>--}}
{{--                      </button>--}}
{{--                    </div>--}}
{{--                    <div class="col-6 col-sm-auto order-2 order-sm-4 d-flex align-items-start justify-content-end align-self-stretch align-self-sm-auto">--}}
{{--                      <button type="button" name="submit" class="p-0 btn bg-transparent shadow-0 border-0" style="color: #DE6D2D" onclick="event.stopPropagation();" @click="$store.commit('removeItem', product.item.id)">--}}
{{--                        <i class="bx bxs-trash bx-sm"></i>--}}
{{--                      </button>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--              <div class="row align-items-center flex-wrap-reverse justify-content-between mt-3 ml-0">--}}
{{--                <div class="col-12 col-md-5 d-flex align-items-end align-self-start p-0">--}}
{{--                  <a href="{{ route('cart.index') }}" class="btn btn-dark py-3 w-100" style="font-size: 1em;" :class="$store.getters.productsCart.length < 1 ? 'disabled' : null">Перейти в корзину</a>--}}
{{--                </div>--}}
{{--                <div class="col-12 col-md-6 d-flex d-md-block justify-content-between ml-2 mb-3 mb-md-0" style="text-align: right;">--}}
{{--                  <div class="row">--}}
{{--                    <div class="col-6 col-12 d-flex justify-content-start justify-content-md-end align-items-center p-0">--}}
{{--                      <p class="h6 font-weight-bold mb-1">Итого: @{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</p>--}}
{{--                    </div>--}}
{{--                    <div class="col-12 d-flex justify-content-start justify-content-md-end p-0">--}}
{{--                      <button class="bg-transparent border-0 text-decoration-none p-0" onclick="event.stopPropagation();" @click="$store.commit('clearCart')" style="color: #DE6D2D">Очистить корзину</button>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--        </ul>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </nav>--}}
{{--  <hr>--}}
{{--  <div class="container search hide">--}}
{{--    <form action="{{ route('product.search') }}" method="GET">--}}
{{--      <div class="input-group">--}}
{{--        <div class="form-outline">--}}
{{--          <i class="d-block d-md-none bx bx bx-search"></i>--}}
{{--          <i class="d-none d-md-block bx bx-sm bx-search"></i>--}}
{{--          <input autocomplete="none" type="text" id="search" name="q" class="form-control" />--}}
{{--          <label class="form-label" for="search">Что-то искали?</label>--}}
{{--        </div>--}}
{{--        <button class="btn btn-dark font-weight-light">Найти</button>--}}
{{--        <a onclick="toggleSearch()">Закрыть</a>--}}
{{--      </div>--}}
{{--    </form>--}}
{{--  </div>--}}

{{--  <nav class="navbar navbar-expand category-menu">--}}
{{--    <div class="container-fluid container-md w-100">--}}
{{--      <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">--}}
{{--        <ul class="navbar-nav align-items-center w-100">--}}
{{--          <li class="nav-item ml-auto">--}}
{{--            <a href="{{ route('index') }}" class="nav-link">Главная</a>--}}
{{--          </li>--}}

{{--          @foreach(\App\Models\Category::whereDoesntHave('parents')->get() as $index => $category)--}}

{{--            <li class="nav-item dropdown">--}}
{{--              <a--}}
{{--                class="nav-link dropdown-toggle"--}}
{{--                href="#"--}}
{{--                id="navbarDropdown"--}}
{{--                role="button"--}}
{{--                data-mdb-toggle="dropdown"--}}
{{--                aria-expanded="false"--}}
{{--              >--}}
{{--                <span>{{ $category->name }}</span>--}}
{{--              </a>--}}

{{--              <div class="triangle" aria-labelledby="navbarDropdown"></div>--}}

{{--              <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--                <div class="container">--}}

{{--                  <div class="row">--}}

{{--                    @foreach($category->child as $childCategory)--}}
{{--                      <div class="col-6 col-md-4 col-lg-3 flex-column" >--}}
{{--                        <a class="item font-weight-bold text-black" href="{{ route('product.all', ['category' => $childCategory->id]) }}">{{ $childCategory->name }}</a>--}}
{{--                        @foreach($childCategory->child as $thirdCategory)--}}
{{--                          <a class="item" href="{{ route('product.all', ['category' => $thirdCategory->id]) }}">{{ $thirdCategory->name }}</a>--}}
{{--                        @endforeach--}}
{{--                      </div>--}}
{{--                    @endforeach--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </li>--}}

{{--          @endforeach--}}

{{--          <li class="nav-item">--}}
{{--            <a--}}
{{--              class="nav-link text-danger"--}}
{{--              href="{{ route('product.all', ['sale' => true]) }}"--}}
{{--            >--}}
{{--              <span>Sale</span>--}}
{{--            </a>--}}
{{--          </li>--}}
{{--          <li class="nav-item dropdown mr-auto">--}}
{{--            <a--}}
{{--              class="nav-link dropdown-toggle"--}}
{{--              href="#"--}}
{{--              id="navbarDropdown"--}}
{{--              role="button"--}}
{{--              data-mdb-toggle="dropdown"--}}
{{--              aria-expanded="false"--}}
{{--            >--}}
{{--              <span>Бренды</span>--}}
{{--            </a>--}}

{{--            <div class="triangle" aria-labelledby="navbarDropdown"></div>--}}

{{--            <div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--              <div class="container">--}}

{{--                <div class="row">--}}
{{--                  <?php--}}
{{--                    $countBrands = (int) (App\Models\Brand::count() / 4);--}}

{{--                    \App\Models\Brand::chunk($countBrands, function ($brands) {--}}
{{--                      echo '<div class="col-6 col-md-4 col-lg-3 flex-column" >';--}}
{{--                      foreach ($brands as $brand) {--}}
{{--                        echo '<a class="item" href="' . route('product.all', ['brand' => $brand->id]) . '">' . $brand->name . '</a>';--}}
{{--                      }--}}
{{--                      echo '</div>';--}}
{{--                    });--}}
{{--                  ?>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </li>--}}
{{--        </ul>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </nav>--}}
{{--  <hr>--}}
</div>
