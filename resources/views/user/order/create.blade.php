@extends('user.layouts.app')
@section('title', 'DOCKU | Оплата')

@section('style')
  <style>
  </style>
@endsection

@section('content')
  <div class="container mt-2 order-create-page">
    <order inline-template >
      <transition name="slide-fade" mode="out-in" appear>
        <div key="windowOrder" class="row justify-content-start flex-column flex-md-row mt-5" v-if="!windowsLoader">
          <div class="col-12 col-md-7">
            <div class="row">

              <div class="col-12 mb-4">
                <p class="h4 title">Адрес доставки</p>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <country :id="'country'"
                         :name="'country'"
                         v-on:set="setCountry"
                         :country_props="{{ json_encode(auth()->user()->country ?? null) }}"
                         ref="country"></country>
              </div>

              <div class="col-12 col-md-6 mb-3">
                <city :id="'city'"
                      :name="'city'"
                      v-on:set="setCity"
                      :city_props="{{ json_encode(auth()->user()->city ?? null) }}"
                      ref="city"></city>
              </div>

              <div class="col-md-6 mb-3">
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
                </div>
              </div>

              <div class="col-md-6 mb-5">
                <div class="form-outline">
                  <input type="text"
                         id="post_code"
                         name="post_code"
                         class="form-control {{ (auth()->user()->post_code ?? null) ? 'active' : '' }}"
                         value="{{ auth()->user()->post_code ?? null }}"
                         @input="setPostCode"/>
                  <label class="form-label"
                         for="post_code">
                    Индекс
                    <span class="required">*</span>
                  </label>
                </div>
              </div>

              <div class="col-12 mb-4">
                <p class="h4 title">Контактные данные</p>
              </div>

              <div class="col-12 mb-3">
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
                </div>
              </div>

              <div class="col-12 col-md-6 mb-3">
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
                </div>
              </div>

              <div class="col-12 col-md-6 mb-5">
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
                </div>
              </div>

              <div class="col-12 mb-4">
                <p class="h4 title">Доставка</p>
              </div>

              <transition name="slide-fade" mode="out-in" appear>

                <div class="col-12 mb-3" v-if="info.city ? info.city.pickup : false" key="1">
                  <div class="choosable-field" :class="transfer.name === 'pickup' ? 'active' : null" @click="setPickupTransfer">
                    <div class="row">
                      <div class="col-8 d-flex flex-column">
                        <span class="title">Самовывоз из магазина</span>
                        <span class="description">Закажите онлайн и заберите в нашем магазине</span>
                      </div>
                      <div class="col-4 d-flex justify-content-end">
                        <span class="price">0 @{{ $store.state.currency.symbol }}</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-3" v-else key="2">
                  <div class="choosable-field">
                    <div class="row">
                      <div class="col-8 d-flex flex-column">
                        <span class="title">@{{ info.city.pickup !== null ? 'В вашем городе нет самовывоза' : 'Вы не выбрали город' }}</span>
                        <span class="description">Упс...</span>
                      </div>
                      <div class="col-4 d-flex justify-content-end">
                        <span class="price"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </transition>

              <transition name="slide-fade" mode="out-in" appear>

                <div class="col-12 mb-3" v-if="errors.ems !== null" :key="1">
                  <div class="choosable-field" style="cursor: default">
                    <div class="row">
                      <div class="col-8 d-flex flex-column">
                        <span class="title">Стандартная доставка</span>
                        <span class="description text-danger">@{{ errors.ems }}</span>
                        <a target="_blank" href="https://wa.me/+77475562383?text=Здравствуйте!%20На%20вашем%20сайте%20нет%20моего%20города%20для%20доставки">Написать в поддержку</a>
                      </div>
                      <div class="col-4 d-flex justify-content-end">
{{--                        <span class="price">1123</span>--}}
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-12 mb-3" v-if="!ems.error && ems.price !== null" :key="2">
                  <div class="choosable-field" :class="transfer.name === 'ems' ? 'active' : null" @click="setEmsTransfer">
                    <div class="row">
                      <div class="col-8 d-flex flex-column">
                        <span class="title">Стандартная доставка</span>
                        <span class="description">Доставка осуществляется от 4 до 7 дней сервисом Kaz Post</span>
                      </div>
                      <div class="col-4 d-flex justify-content-end">
                        <span class="price">@{{ $cost(ems.price * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </transition>

              <transition name="slide-fade" mode="out-in" appear>
                <div class="col-12" v-if="transfer.name !== null">
                  <div class="row">
                    <div class="col-12 mb-4">
                      <p class="h4 title">Оплата</p>
                    </div>
                    @if($cash ? ($cash->data === '1') : false)
                      <div class="col-12 mb-3" v-if="transfer.name !== 'ems'">
                        <div class="choosable-field"
                             :class="method_pay === 'cash' ? 'active' : null"
                             @click="setCashMethod">
                          <div class="row">
                            <div class="col-8 d-flex flex-column">
                              <span class="title">Оплата при получении</span>
                              <span class="description">Оплатите курьеру или в магазине после получения</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif

                    @if($cloudPayment ? ($cloudPayment->data === '1') : false)
                      <div class="col-12 mb-5">
                        <div class="choosable-field"
                             :class="method_pay === 'cloudPayment' ? 'active' : null"
                             @click="setCloudPaymentMethod">
                          <div class="row">
                            <div class="col-8 d-flex flex-column">
                              <span class="title">Оплатить онлайн</span>
                              <span class="description">Оплатите онлайн любым удобным способом через сервис cloud payments</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif

                  </div>
                </div>
              </transition>
            </div>
          </div>
          <div class="col-12 col-md-5">
            <div class="row">
              <div class="col-12 justify-content-end d-flex mb-3 mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none" v-if="!$store.state.auth" style="font-size: .9em;">Войдите в аккаунт,
                  чтобы оплачивать быстрее</a>
              </div>
              <div class="col-12 mb-2" :class="$store.state.auth ? 'mt-3' : null">
                <div class="order-results">
                  <div class="row">
                    <div class="col-12">
                      <span>Сумма покупок</span>
                      <span>@{{ $cost($store.getters.priceAmount) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12">
                      <span>Доставка</span>
                      <span>@{{ $cost(transfer.price * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12" v-if="sale">
                      <span>Скидка</span>
                      <span>- @{{ $cost(price_with_sale * $store.state.currency.ratio) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                    <div class="col-12">
                      <span>Итог заказа</span>
                      <span class="font-weight-bold">@{{ $cost(price) }} @{{ $store.state.currency.symbol }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-outline">
                  <input type="text" id="promocode" name="promocode" class="form-control" v-model="code"/>
                  <label class="form-label" for="promocode">Введите промокод (при наличии)</label>
                </div>
              </div>
              <div class="col-12 mb-5">
                <button @click="checkSale" class="btn btn-dark d-block w-100 mt-2 py-3 promocode-button" :disabled="disabledButtonCode">Активировать промокод</button>
              </div>

              <div class="col-12">
                <div class="row">
                  <div class="col-12 mb-3">
                    <span class="h5 title">Позиции заказа</span>
                  </div>
                  <transition name="slide-fade" mode="out-in" appear>
                    <div class="col-12" v-if="!$root.cartLoader" key="products">
                      <div class="row">
                        <div class="col-12 mb-3" v-for="product in $store.getters.productsCart">
                          <div class="row">
                            <div class="col-3">
                              <img :src="product.thumbnail_jpg" :alt="product.title" class="w-100" style="object-fit: cover">
                            </div>
                            <div class="col-9 d-flex flex-column justify-content-around pl-0"
                                 style="border-bottom: 1px solid #E9EAEC;">
                              <span style="font-weight: 500;">@{{ product.title }}</span>
                              <span class="font-weight-bold">
                            @{{ $cost((product.on_sale ? product.price_sale : product.price) * $store.state.currency.ratio * product.item.amount) }} @{{ $store.state.currency.symbol }}
                          </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12" v-else key="loader">
                      <div class="row justify-content-center">
                        <div class="col-auto">
                          <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </transition>

                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-7">
            <div class="row">
              <div class="col-md-6 d-flex">
                <button class="btn btn-dark complete" id="checkout" @click="orderedNow" :disabled="disabledButton">
                  <span v-if="!loaderButton">Завершить и перейти к оплате</span>
                  <div v-else class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </button>
              </div>
              <div class="col-md-6 d-flex">
                <button class="btn btn-outline-dark complete" @click="orderAfter" data-mdb-ripple-color="dark" id="checkout" :disabled="disabledButtonAfter">
                  <span v-if="!loaderButtonAfter">Завершить и оплатить позже</span>

                  <div v-else class="spinner-border text-dark" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </button>
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
