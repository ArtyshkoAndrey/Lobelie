@extends('user.layouts.app')
@section('title', 'DOCKU | Оплата')

@section('style')
  <style>
  </style>
@endsection

@section('content')
  <div class="container-fluid order-create-page">
    <order inline-template >
      <transition name="slide-fade" mode="out-in" appear>
        <div key="windowOrder" class="row justify-content-start flex-column flex-md-row mt-5" v-if="!windowsLoader">
          <div class="col-12 col-md-8">
            <div class="row mb-4">
              <div class="col-12 col-sm-6 d-flex flex-column">
                <p class="h4 title">Личные данные</p>
                <div class="form-outline">
                  <input type="text"
                         id="name"
                         name="name"
                         class="form-control {{ (auth()->user()->name ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->name ?? null }}"
                         @input="setName"/>
                  <label class="form-label"
                         for="name">
                    ФИО
                    <span class="required">*</span>
                  </label>
                  <span class="icon">
                    <i class="las la-user"></i>
                  </span>
                </div>
                <div class="form-outline">
                  <input type="text"
                         id="phone"
                         name="phone"
                         class="form-control {{ (auth()->user()->phone ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->phone ?? '' }}"
                         @input="setPhone"/>
                  <label class="form-label"
                         for="phone">
                    Телефон
                    <span class="required">*</span>
                  </label>
                  <span class="icon">
                    <i class="las la-phone"></i>
                  </span>
                </div>
                <div class="form-outline">
                  <input type="email"
                         id="email"
                         name="email"
                         class="form-control {{ (auth()->user()->email ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->email ?? null }}"
                         @input="setEmail" />
                  <label class="form-label"
                         for="email">
                    E-mail
                    <span class="required">*</span>
                  </label>
                  <span class="icon">
                    <i class="las la-envelope"></i>
                  </span>
                </div>
              </div>
              <div class="col-12 col-sm-6">
                <p class="h4 title">Адрес доставки</p>
                <country :id="'country'"
                         :name="'country'"
                         v-on:set="setCountry"
                         :country_props="{{ json_encode(auth()->user()->country ?? null) }}"
                         ref="country"></country>
                <city :id="'city'"
                      :name="'city'"
                      v-on:set="setCity"
                      :city_props="{{ json_encode(auth()->user()->city ?? null) }}"
                      ref="city"></city>
                <div class="form-outline">
                  <input type="text"
                         id="address"
                         name="address"
                         class="form-control {{ (auth()->user()->address ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->address ?? null }}"
                         @input="setAddress"/>
                  <label class="form-label"
                         for="address">
                    Точный адрес
                    <span class="required">*</span>
                  </label>
                  <span class="icon">
                    <i class="las la-map-marker-alt"></i>
                  </span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                <p class="h4 title">Способ оплаты</p>
                <div class="choice-field active">
                  <i class="icon las la-credit-card"></i>
                  <span class="content">Оплатить картой</span>
                  <div class="radio-wrapper">
                    <div class="radio"></div>
                    <div class="dot"></div>
                  </div>
                </div>
                <div class="choice-field">
                  <i class="icon las la-money-bill"></i>
                  <span class="content">Наличными</span>
                  <div class="radio-wrapper">
                    <div class="radio"></div>
                    <div class="dot"></div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-12 col-lg-6">
                <p class="h4 title">Способ доставки</p>
                <div class="choice-field active">
                  <span class="content">Самовывоз</span>
                  <span>0 ₸</span>
                  <div class="radio-wrapper">
                    <div class="radio"></div>
                    <div class="dot"></div>
                  </div>
                </div>
                <div class="choice-field">
                  <span class="content">Стандартная доставка</span>
                  <span>1 000 ₸</span>
                  <div class="radio-wrapper">
                    <div class="radio"></div>
                    <div class="dot"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="row">
              <div class="col-12 justify-content-end d-flex mbСумма: mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none" v-if="!$store.state.auth" style="font-size: .9em;">Войдите в аккаунт,
                  чтобы оплачивать быстрее</a>
              </div>
              <div class="col-12 mb-2" :class="$store.state.auth ? 'mt-3' : null">
                <div class="order-results">
                  <div class="row">
                    <div class="col-12">
                      <span>Сумма:</span>
                      <span>@{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12">
                      <span>Скидка:</span>
                      <span>- @{{ $cost(price_with_sale * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12 result">
                      <span>Итого:</span>
                      <span>@{{ $cost(price) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12">
                      <button @click="checkSale" class="complete-button">Завершить и оплатить</button>
                    </div>
                    <div class="col-12 agreement">
                      <span>Нажимая на кнопку “Завершить и оплатить” вы соглашаетесь с политикой конфиденциальности</span>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <div v-else key="loaderWindow" class="mt-5">
          <div class="row">
            <div class="col-12 text-center">
              <h3><strong>Не закрывайте браузер.</strong> Ожидаем подтверждения оплаты</h3>
            </div>
          </div>
          <div class="row justify-content-center my-5">
            <div class="col-auto">
              <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>
          </div>
        </div>
      </transition>

    </order>

  </div>
@endsection

@section('js')
  <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>

  <script>

    pay = function () {
      let widget = new cp.CloudPayments();
      widget.pay('auth', // или 'charge'
        { //options
          publicId: 'test_api_00000000000000000000001', //id из личного кабинета
          description: 'Оплата товаров в example.com', //назначение
          amount: 100, //сумма
          currency: 'RUB', //валюта
          invoiceId: '1234567', //номер заказа  (необязательно)
          accountId: 'user@example.com', //идентификатор плательщика (необязательно)
          skin: "mini", //дизайн виджета (необязательно)
          data: {
            myProp: 'myProp value'
          }
        },
        {
          onSuccess: function (options) { // success
            //действие при успешной оплате
          },
          onFail: function (reason, options) { // fail
            //действие при неуспешной оплате
          },
          onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
            //например вызов вашей аналитики Facebook Pixel
          }
        }
      )
    };

    // $('#checkout').click(pay);
  </script>
  <script>
    $('#phone').mask('+7 (000) 000-00-00')
  </script>
@endsection
